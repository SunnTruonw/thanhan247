<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//model
use App\Models\Exam;
use App\Models\CategoryExam;
use App\Models\ExamTranslation;
use App\Models\Question;
use App\Models\QuestionAnswer;
// support
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
//validate
use App\Http\Requests\Admin\Exam\ValidateAddExam;
use App\Http\Requests\Admin\Exam\ValidateEditExam;
//trait
use App\Traits\StorageImageTrait;
use App\Traits\DeleteRecordTrait;

class AdminExamController extends Controller
{
    use StorageImageTrait, DeleteRecordTrait;
    private $exam;
    private $categoryExam;
    private $htmlselect;
    private $question;
    private $questionAnswer;
    private $langConfig;
    private $langDefault;

    public function __construct(
        Exam $exam,
        CategoryExam $categoryExam,
        ExamTranslation $examTranslation,
        QuestionAnswer $questionAnswer,
        Question $question
    ) {
        $this->exam = $exam;
        $this->categoryExam = $categoryExam;
        $this->examTranslation = $examTranslation;
        $this->langConfig = config('languages.supported');
        $this->langDefault = config('languages.default');
        $this->questionAnswer = $questionAnswer;
        $this->question = $question;
    }
    //
    public function index(Request $request)
    {
        $data = $this->exam;
        if ($request->input('category')) {
            $categoryExamId = $request->input('category');
            $idCategorySearch = $this->categoryExam->getALlCategoryChildren($categoryExamId);
            $idCategorySearch[] = (int)($categoryExamId);
            $data = $data->whereIn('category_id', $idCategorySearch);
            $htmlselect = $this->categoryExam->getHtmlOption($categoryExamId);
        } else {
            $htmlselect = $this->categoryExam->getHtmlOption();
        }
        $where = [];
        if ($request->input('keyword')) {
            // $where[] = ['name', 'like', '%' . $request->input('keyword') . '%'];
            $data = $data->where(function ($query) {
                $idExamTran = $this->examTranslation->where([
                    ['name', 'like', '%' . request()->input('keyword') . '%']
                ])->pluck('exam_id');
                // dd($idProTran);
                $query->whereIn('id', $idExamTran);
            });
        }
        if ($request->has('fill_action') && $request->input('fill_action')) {
            $key = $request->input('fill_action');
            switch ($key) {
                case 'hot':
                    $where[] = ['hot', '=', 1];
                    break;
                case 'noHot':
                    $where[] = ['hot', '=', 0];
                    break;
                default:
                    break;
            }
        }
        if ($where) {
            $data = $data->where($where);
        }
        if ($request->input('order_with')) {
            $key = $request->input('order_with');
            switch ($key) {
                case 'dateASC':
                    $orderby = ['created_at'];
                    break;
                case 'dateDESC':
                    $orderby = [
                        'created_at',
                        'DESC'
                    ];
                    break;
                case 'viewASC':
                    $orderby = [
                        'view',
                        'ASC'
                    ];
                    break;
                case 'viewDESC':
                    $orderby = [
                        'view',
                        'DESC'
                    ];
                    break;
                default:
                    $orderby =  $orderby = [
                        'created_at',
                        'DESC'
                    ];
                    break;
            }
            $data = $data->orderBy(...$orderby);
        } else {
            $data = $data->orderBy("created_at", "DESC");
        }
        $data = $data->paginate(15);

        return view(
            "admin.pages.exam.list",
            [
                'data' => $data,
                'option' => $htmlselect,
                'keyword' => $request->input('keyword') ? $request->input('keyword') : "",
                'order_with' => $request->input('order_with') ? $request->input('order_with') : "",
                'fill_action' => $request->input('fill_action') ? $request->input('fill_action') : "",
            ]
        );
    }

    public function create(Request $request)
    {
        if($request->has('category_id')){
            $htmlselect = $this->categoryExam->getHtmlOption($request->category_id);
        }else{
            $htmlselect = $this->categoryExam->getHtmlOption();
        }

        return view(
            "admin.pages.exam.add",
            [
                'option' => $htmlselect,
                'request' => $request
            ]
        );
    }

    public function store(ValidateAddExam $request)
    {
        try {
            DB::beginTransaction();
            $dataExamCreate = [
                "hot" => $request->input('hot') ?? 0,
                "view" => $request->input('view') ?? 0,
                "order" => $request->input('order') ?? 0,
                "time" => $request->input('time'),
                "active" => $request->input('active'),
                "category_id" => $request->input('category_id'),
                "admin_id" => auth()->guard('admin')->id()
            ];
            $dataUploadAvatar = $this->storageTraitUpload($request, "avatar_path", "exam");
            if (!empty($dataUploadAvatar)) {
                $dataExamCreate["avatar_path"] = $dataUploadAvatar["file_path"];
            }
            // insert database in exams table
            $exam = $this->exam->create($dataExamCreate);
            // dd($exam);
            // insert data product lang
            $dataExamTranslation = [];
            //  dd($this->langConfig);
            foreach ($this->langConfig as $key => $value) {
                $itemExamTranslation = [];
                $itemExamTranslation['name'] = $request->input('name_' . $key);
                $itemExamTranslation['slug'] = $request->input('slug_' . $key);
                $itemExamTranslation['description'] = $request->input('description_' . $key);
                $itemExamTranslation['description_seo'] = $request->input('description_seo_' . $key);
                $itemExamTranslation['title_seo'] = $request->input('title_seo_' . $key);
                $itemExamTranslation['keyword_seo'] = $request->input('keyword_seo_' . $key);
                $itemExamTranslation['content'] = $request->input('content_' . $key);
                $itemExamTranslation['language'] = $key;
                //  dd($itemExamTranslation);
                $dataExamTranslation[] = $itemExamTranslation;
            }
            // dd($dataExamTranslation);
            // dd($exam->translations());
            $examTranslation =   $exam->translations()->createMany($dataExamTranslation);

            DB::commit();
            return redirect()->route('admin.exam.index', ['category' => $exam->category_id])->with("alert", "Thêm Exam thành công");
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.exam.index', ['category' => $exam->category_id])->with("error", "Thêm Exam không thành công");
        }
    }

    public function edit($id)
    {
        $data = $this->exam->find($id);
        $category_id = $data->category_id;
        $htmlselect = $this->categoryExam->getHtmlOption($category_id);
        return view("admin.pages.exam.edit", [
            'option' => $htmlselect,
            'data' => $data,
        ]);
    }



    public function update(ValidateEditExam $request, $id)
    {
        try {
            DB::beginTransaction();
            $dataExamUpdate = [
                "order" => $request->input('order') ?? 0,
                "hot" => $request->input('hot') ?? 0,
                "active" => $request->input('active'),
                "category_id" => $request->input('category_id'),
                "admin_id" => auth()->guard('admin')->id(),
            ];
            $dataUploadAvatar = $this->storageTraitUpload($request, "avatar_path", "exam");
            if (!empty($dataUploadAvatar)) {
                $path = $this->exam->find($id)->avatar_path;
                if ($path) {
                    Storage::delete($this->makePathDelete($path));
                }
                $dataExamUpdate["avatar_path"] = $dataUploadAvatar["file_path"];
            }

            // insert database in exam table
            $this->exam->find($id)->update($dataExamUpdate);
            $exam = $this->exam->find($id);

            // insert data product lang
            $dataExamTranslationUpdate = [];
            foreach ($this->langConfig as $key => $value) {
                $itemExamTranslationUpdate = [];
                $itemExamTranslationUpdate['name'] = $request->input('name_' . $key);
                $itemExamTranslationUpdate['slug'] = $request->input('slug_' . $key);
                $itemExamTranslationUpdate['description'] = $request->input('description_' . $key);
                $itemExamTranslationUpdate['description_seo'] = $request->input('description_seo_' . $key);
                $itemExamTranslationUpdate['title_seo'] = $request->input('title_seo_' . $key);
                $itemExamTranslationUpdate['keyword_seo'] = $request->input('keyword_seo_' . $key);
                $itemExamTranslationUpdate['content'] = $request->input('content_' . $key);
                $itemExamTranslationUpdate['language'] = $key;

                if ($exam->translationsLanguage($key)->first()) {
                    $exam->translationsLanguage($key)->first()->update($itemExamTranslationUpdate);
                } else {
                    $exam->translationsLanguage($key)->create($itemExamTranslationUpdate);
                }
            }
            DB::commit();
            return redirect()->route('admin.exam.index')->with("alert", "sửa Exam thành công");
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.exam.index')->with("error", "Sửa Exam không thành công");
        }
    }
    public function destroy($id)
    {
        return $this->deleteTrait($this->exam, $id);
    }

    public function loadActive($id)
    {
        $exam   =  $this->exam->find($id);
        $active = $exam->active;
        if ($active) {
            $activeUpdate = 0;
        } else {
            $activeUpdate = 1;
        }
        $updateResult =  $exam->update([
            'active' => $activeUpdate,
        ]);
        $exam   =  $this->exam->find($id);
        if ($updateResult) {
            return response()->json([
                "code" => 200,
                "html" => view('admin.components.load-change-active', ['data' => $exam, 'type' => 'exam'])->render(),
                "message" => "success"
            ], 200);
        } else {
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }
    }
    public function loadHot($id)
    {
        $exam   =  $this->exam->find($id);
        $hot = $exam->hot;

        if ($hot) {
            $hotUpdate = 0;
        } else {
            $hotUpdate = 1;
        }
        $updateResult =  $exam->update([
            'hot' => $hotUpdate,
        ]);

        $exam   =  $this->exam->find($id);
        if ($updateResult) {
            return response()->json([
                "code" => 200,
                "html" => view('admin.components.load-change-hot', ['data' => $exam, 'type' => 'exam'])->render(),
                "message" => "success"
            ], 200);
        } else {
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }
    }

    // thêm câu hỏi câu trả lời bài thi


    // xử lý question


    public function show($id)
    {
        $data = $this->exam->find($id);
        return view("admin.pages.exam.show", [
            'data' => $data
        ]);
    }
    //load view thêm question
    public function loadCreateQuestion($id, Request $request)
    {
        $dataView = [];
        $dataView['typeQuestion'] = $request->type;
        $exam = $this->exam->find($id);
        $dataView['exam'] = $exam;
        if ($exam) {
            return response()->json([
                "code" => 200,
                "html" =>  view('admin.components.question.add-ajax-question', $dataView)->render(),
                "message" => "success"
            ], 200);
        } else {
            return response()->json([
                "code" => 500,
                "message" => "error"
            ], 500);
        }
    }
    //load view thêm câu trả lời
    public function loadCreateQuestionAnswer(Request $request)
    {
        $i = $request->i;
        return response()->json([
            "code" => 200,
            "html" =>  view('admin.components.question.add-question-answer', ['i' => $i])->render(),
            "message" => "success"
        ], 200);
    }

    public function storeQuestion(Request $request, $id)
    {
        $rule = [
            "orderQuestion" => "numeric|nullable",
            "typeQuestion" => "required|numeric",
            "activeQuestion" => "required|numeric",
            "codeAnswer.*" => "required"
        ];
        $langConfig = config('languages.supported');
        $langDefault = config('languages.default');

        foreach ($langConfig as $key => $value) {
            $rule['nameAnswer_' . $key . '.*'] = "required|min:1";
            $rule['nameQuestion_' . $key] = "required|min:1";
        }

        $validator = Validator::make($request->all(), $rule);
        if ($request->has('correctAnswer')) {
            $validator->after(function ($validator) {

                if (!collect(request()->input('correctAnswer'))->contains(1)) {
                    $validator->errors()->add(
                        'answer',
                        'Bạn phải chọn ít nhất 1 đáp án đúng trong danh sách đáp án của bạn!'
                    );
                }
            });
        }



        if ($validator->passes()) {
            try {
                DB::beginTransaction();
                $exam = $this->exam->find($id);
                $dataQuestionCreate = [
                    //  "title" => $request->input('titleQuestion') ?? null,
                    // "name" => $request->input('nameQuestion') ?? null,
                    //  "answer" => $request->input('answerQuestion') ?? null,
                    "order" => $request->input('orderQuestion') ?? 0,
                    "type" => $request->input('typeQuestion'),
                    "active" => $request->input('activeQuestion'),
                    "admin_id" => auth()->guard('admin')->id()
                ];

                $question = $exam->questions()->create($dataQuestionCreate);

                $dataQuestionTranslation = [];
                //  dd($this->langConfig);
                foreach ($this->langConfig as $key => $value) {
                    $itemQuestionTranslation = [];
                    $itemQuestionTranslation['name'] = $request->input('nameQuestion_' . $key);
                    $itemQuestionTranslation['title'] = $request->input('titleQuestion_' . $key) ?? null;
                    $itemQuestionTranslation['answer'] = $request->input('answerQuestion_' . $key) ?? null;
                    $itemQuestionTranslation['language'] = $key;
                    $dataQuestionTranslation[] = $itemQuestionTranslation;
                }

                $questionTranslation =   $question->translations()->createMany($dataQuestionTranslation);

                //  dd($questionTranslation);

                // insert database to product_images table

                if ($request->has("codeAnswer")) {
                    $dataQuestionAnswerCreate = [];
                    foreach ($request->input('codeAnswer') as $key => $value) {
                        $itemQuestionAnswerCreate = [
                            "code" => $value,
                            "correct" => $request->input('correctAnswer')[$key],
                            "admin_id" => auth()->guard('admin')->id()
                        ];

                        $answer = $question->answers()->create($itemQuestionAnswerCreate);
                        $dataQuestionAnswerTranslation = [];
                        foreach ($this->langConfig as $keyL => $valueL) {
                            $itemQuestionAnswerTranslation = [];
                            $itemQuestionAnswerTranslation['name'] = $request->input('nameAnswer_' . $keyL)[$key];
                            $itemQuestionAnswerTranslation['language'] = $keyL;
                            $dataQuestionAnswerTranslation[] = $itemQuestionAnswerTranslation;
                        }

                        $answerTranslation = $answer->translations()->createMany($dataQuestionAnswerTranslation);
                    }
                }

                DB::commit();
                return response()->json([
                    'code' => 200,
                    'html' => view('admin.components.question.load-list-question', [
                        'data' => $exam,
                        'type' => config('web_default.typeQuestion'),
                        'typeActive' => $question->type,
                    ])->render(),
                    'messange' => 'success'
                ], 200);
            } catch (\Exception $exception) {
                //throw $th;
                DB::rollBack();
                Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
                return response()->json([
                    'code' => 500,
                    'messange' => 'error'
                ], 500);
            }
        } else {
            return response()->json([
                'code' => 200,
                'htmlErrorValidate' => view('admin.components.load-error-ajax', [
                    "errors" => $validator->errors()
                ])->render(),
                'messange' => 'success',
                'validate' => true
            ], 200);
        }
    }

    public function loadEditQuestion($id, Request $request)
    {
        $question = $this->question->find($id);
        // dd($paragraphProgram->program()->get());
        $dataView['data'] = $question;

        if ($question) {
            return response()->json([
                "code" => 200,
                "html" =>  view('admin.components.question.edit-ajax-question', $dataView)->render(),
                "message" => "success"
            ], 200);
        } else {
            return response()->json([
                "code" => 500,
                "message" => "error"
            ], 500);
        }
    }


    public function updateQuestion(Request $request, $id)
    {
        $rule = [];
        $langConfig = config('languages.supported');
        $langDefault = config('languages.default');
        foreach ($langConfig as $key => $value) {
            $rule['nameQuestion_' . $key] = "required|min:1";
        }
        $validator = Validator::make($request->all(), $rule);
        if ($validator->passes()) {
            try {
                DB::beginTransaction();
                $dataQuestionUpdate = [
                    // "title" => $request->input('titleQuestion') ?? null,
                    // "name" => $request->input('nameQuestion'),
                    "order" => $request->input('orderQuestion') ?? 0,
                    // "answer" => $request->input('answerQuestion') ?? null,
                    "type" => $request->input('typeQuestion'),
                    "active" => $request->input('activeQuestion'),
                    "admin_id" => auth()->guard('admin')->id()
                ];

                $this->question->find($id)->update($dataQuestionUpdate);

                // insert or update data question lang
                $question = $this->question->find($id);
                $dataQuestionTranslationUpdate = [];
                foreach ($this->langConfig as $key => $value) {
                    $itemQuestionTranslationUpdate = [];
                    $itemQuestionTranslationUpdate['name'] = $request->input('nameQuestion_' . $key);
                    $itemQuestionTranslationUpdate['title'] = $request->input('titleQuestion_' . $key) ?? null;
                    $itemQuestionTranslationUpdate['answer'] = $request->input('answerQuestion_' . $key) ?? null;
                    $itemQuestionTranslationUpdate['language'] = $key;

                    if ($question->translationsLanguage($key)->first()) {
                        $question->translationsLanguage($key)->first()->update($itemQuestionTranslationUpdate);
                    } else {
                        $question->translationsLanguage($key)->create($itemQuestionTranslationUpdate);
                    }
                }

                DB::commit();
                return response()->json([
                    'code' => 200,
                    'html' => view('admin.components.question.load-list-question', [
                        'data' => $question->exam,
                        'type' => config('web_default.typeQuestion'),
                        'typeActive' => $question->type,
                    ])->render(),
                    'messange' => 'success'
                ], 200);
            } catch (\Exception $exception) {
                //throw $th;
                DB::rollBack();
                Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
                return response()->json([
                    'code' => 500,
                    'messange' => 'error'
                ], 500);
            }
        } else {
            return response()->json([
                'code' => 200,
                'htmlErrorValidate' => view('admin.components.load-error-ajax', [
                    "errors" => $validator->errors()
                ])->render(),
                'messange' => 'success',
                'validate' => true
            ], 200);
        }
    }
    public function destroyQuestion($id)
    {
        return $this->deleteTrait($this->question, $id);
    }

    public function loadCreateNowQuestionAnswer($id, Request $request)
    {

        $question = $this->question->find($id);
        return response()->json([
            "code" => 200,
            "html" =>  view('admin.components.question.add-ajax-question-answer', ['data' => $question])->render(),
            "message" => "success"
        ], 200);
    }

    public function loadEditAnswer($id)
    {
        $questionAnswer = $this->questionAnswer->find($id);
        // dd($paragraphProgram->program()->get());
        $dataView['data'] = $questionAnswer;
        $dataView['questionActive'] = $questionAnswer->question->id;
        if ($questionAnswer) {
            return response()->json([
                "code" => 200,
                "html" =>  view('admin.components.question.edit-ajax-question-answer', $dataView)->render(),
                "message" => "success"
            ], 200);
        } else {
            return response()->json([
                "code" => 500,
                "message" => "error"
            ], 500);
        }
    }

    public function updateQuestionAnswer($id, Request $request)
    {

        $rule = [
            "codeAnswer" => "required",
        ];
        $langConfig = config('languages.supported');
        $langDefault = config('languages.default');

        foreach ($langConfig as $key => $value) {
            $rule['nameAnswer_' . $key] = "required|min:1";
        }
        $validator = Validator::make($request->all(), $rule);
        if ($request->has('correctAnswer')&&!$request->input('correctAnswer')) {
            $validator->after(function ($validator) {
                $idA = request()->route()->parameter('id');
                $a=\App\Models\QuestionAnswer::find($idA);
                $q =$a->question;

                if ($q->answers()->where([
                    ['correct', 1],
                    ['id','<>',$idA]
                ])->count() <= 0) {
                    $validator->errors()->add(
                        'answer',
                        'Bạn phải chọn đáp án là đúng. Do câu hỏi của bạn chưa có đáp án đúng nào.
                         Nếu bạn muốn thay đổi đáp án này là sai. Bạn vui lòng chọn 1 đáp án khác của câu hỏi này là đúng trước khi thay đổi đáp án này thành sai!'
                    );
                }
            });
        }

        if ($validator->passes()) {
            $questionAnswer = $this->questionAnswer->find($id);
            try {
                DB::beginTransaction();
                $dataQuestionAnswerUpdate = [
                    "code" => $request->input('codeAnswer'),
                    "correct" => $request->input('correctAnswer'),
                    "admin_id" => auth()->guard('admin')->id()
                ];
                $this->questionAnswer->find($id)->update($dataQuestionAnswerUpdate);
                $questionAnswer = $this->questionAnswer->find($id);
                // insert or update data question lang
                $dataQuestionAnswerTranslationUpdate = [];
                foreach ($this->langConfig as $key => $value) {
                    $itemQuestionAnswerTranslationUpdate = [];
                    $itemQuestionAnswerTranslationUpdate['name'] = $request->input('nameAnswer_' . $key);
                    $itemQuestionAnswerTranslationUpdate['language'] = $key;

                    if ($questionAnswer->translationsLanguage($key)->first()) {
                        $questionAnswer->translationsLanguage($key)->first()->update($itemQuestionAnswerTranslationUpdate);
                    } else {
                        $questionAnswer->translationsLanguage($key)->create($itemQuestionAnswerTranslationUpdate);
                    }
                }
                DB::commit();
                return response()->json([
                    'code' => 200,
                    'html' => view('admin.components.question.load-list-question', [
                        'data' => $questionAnswer->question->exam,
                        'type' => config('web_default.typeQuestion'),
                        'typeActive' => $questionAnswer->question->type,
                        'questionActive'=> $questionAnswer->question->id,
                    ])->render(),
                    'messange' => 'success'
                ], 200);
            } catch (\Exception $exception) {
                //throw $th;
                DB::rollBack();
                Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
                return response()->json([
                    'code' => 500,
                    'messange' => 'error'
                ], 500);
            }
        } else {
            return response()->json([
                'code' => 200,
                'htmlErrorValidate' => view('admin.components.load-error-ajax', [
                    "errors" => $validator->errors()
                ])->render(),
                'messange' => 'success',
                'validate' => true
            ], 200);
        }
    }



    public function storeQuestionAnswer(Request $request, $id)
    {

        $rule = [
            "codeAnswer" => "required",
        ];
        $langConfig = config('languages.supported');
        $langDefault = config('languages.default');

        foreach ($langConfig as $key => $value) {
            $rule['nameAnswer_' . $key] = "required|min:1";
        }
        $validator = Validator::make($request->all(), $rule);
        if ($request->has('correctAnswer')&&!$request->input('correctAnswer')) {
            $validator->after(function ($validator) {
                $idQ = request()->route()->parameter('id');
                $q=\App\Models\Question::find($idQ);
             //   $q =$a->question;
                if ($q->answers()->where([
                    ['correct', 1]
                ])->count() <= 0) {
                    $validator->errors()->add(
                        'answer',
                        'Bạn phải chọn đáp án là đúng. Do câu hỏi của bạn chưa có đáp án đúng nào.'
                        // Nếu bạn muốn thay đổi đáp án này là sai. Bạn vui lòng chọn 1 đáp án khác của câu hỏi này là đúng trước khi thay đổi đáp án này thành sai!
                    );
                }
            });
        }


        if ($validator->passes()) {
            try {
                DB::beginTransaction();
                $question = $this->question->find($id);
                $dataQuestionAnswerCreate = [
                    "code" => $request->input('codeAnswer'),
                    "correct" => $request->input('correctAnswer'),
                    "admin_id" => auth()->guard('admin')->id()
                ];

                $answer = $question->answers()->create($dataQuestionAnswerCreate);
                $dataQuestionAnswerTranslation = [];
                foreach ($this->langConfig as $keyL => $valueL) {
                    $itemQuestionAnswerTranslation = [];
                    $itemQuestionAnswerTranslation['name'] = $request->input('nameAnswer_' . $keyL);
                    $itemQuestionAnswerTranslation['language'] = $keyL;
                    $dataQuestionAnswerTranslation[] = $itemQuestionAnswerTranslation;
                }

                $answerTranslation = $answer->translations()->createMany($dataQuestionAnswerTranslation);

                DB::commit();
                return response()->json([
                    'code' => 200,
                    'html' => view('admin.components.question.load-list-question', [
                        'data' => $question->exam,
                        'type' => config('web_default.typeQuestion'),
                        'typeActive' => $question->type,
                        'questionActive' => $question->id
                    ])->render(),
                    'messange' => 'success'
                ], 200);
            } catch (\Exception $exception) {
                //throw $th;
                DB::rollBack();
                Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
                return response()->json([
                    'code' => 500,
                    'messange' => 'error'
                ], 500);
            }
        } else {
            return response()->json([
                'code' => 200,
                'htmlErrorValidate' => view('admin.components.load-error-ajax', [
                    "errors" => $validator->errors()
                ])->render(),
                'messange' => 'success',
                'validate' => true
            ], 200);
        }
    }


    public function destroyAnswer($id)
    {
        $answer= $this->questionAnswer->find($id);
        if($answer->correct){
            $question =$answer->question;
            if($question->answers()->where([
                ['correct',1],
                ['id','<>',$id]
            ])->count()<=0){
                return response()->json([
                    "code" => 500,
                    "message" => "Đây là đáp án đúng. Bạn phải chọn 1 đáp án đúng cho câu hỏi này trước khi xóa"
                ], 200);
            }else{
                return $this->deleteTrait($this->questionAnswer, $id);
            }
        }else{
            return $this->deleteTrait($this->questionAnswer, $id);
        }
    }

}
