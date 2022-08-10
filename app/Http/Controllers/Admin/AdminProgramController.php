<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Program;
use App\Models\CategoryProgram;
use App\Models\Tag;
use App\Models\ProgramTag;
use App\Models\ParagraphProgram;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Traits\StorageImageTrait;
use App\Traits\DeleteRecordTrait;
use App\Traits\ParagraphTrait;

use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\Program\ValidateAddProgram;
use App\Http\Requests\Admin\Program\ValidateEditProgram;

use App\Exports\ExcelExportsDatabase;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ExcelImportsDatabase;
use App\Models\ProgramTranslation;
use App\Models\Exercise;
use App\Models\ExerciseAnswer;

class AdminProgramController extends Controller
{
    use StorageImageTrait, DeleteRecordTrait, ParagraphTrait;
    private $program;
    private $categoryProgram;
    private $htmlselect;
    private $tag;
    private $programTag;
    private $paragraphProgram;
    private $exercise;
    private $exerciseAnswer;
    private $langConfig;
    private $langDefault;
    private $typeParagraph;
    private $configParagraph;
    public function __construct(
        Program $program,
        ProgramTranslation $programTranslation,
        CategoryProgram $categoryProgram,
        Tag $tag,
        ProgramTag $programTag,
        ParagraphProgram $paragraphProgram,
        Exercise $exercise,
        ExerciseAnswer $exerciseAnswer

    ) {
        $this->program = $program;
        $this->categoryProgram = $categoryProgram;
        $this->programTranslation = $programTranslation;
        $this->tag = $tag;
        $this->programTag = $programTag;
        $this->paragraphProgram = $paragraphProgram;
        $this->exercise = $exercise;
        $this->exerciseAnswer = $exerciseAnswer;
        $this->langConfig = config('languages.supported');
        $this->langDefault = config('languages.default');
        $this->typeParagraph = config('paragraph.programs');
        $this->configParagraph = config('paragraph.programs');
    }
    //
    public function index(Request $request)
    {
        $data = $this->program;
        if ($request->input('category')) {
            $categoryProgramId = $request->input('category');
            $idCategorySearch = $this->categoryProgram->getALlCategoryChildren($categoryProgramId);
            $idCategorySearch[] = (int)($categoryProgramId);
            $data = $data->whereIn('category_id', $idCategorySearch);
            $htmlselect = $this->categoryProgram->getHtmlOption($categoryProgramId);
        } else {
            $htmlselect = $this->categoryProgram->getHtmlOption();
        }
        $where = [];
        if ($request->input('keyword')) {
            // $where[] = ['name', 'like', '%' . $request->input('keyword') . '%'];
            $data = $data->where(function ($query) {
                $idProgramTran = $this->programTranslation->where([
                    ['name', 'like', '%' . request()->input('keyword') . '%']
                ])->pluck('program_id');
                // dd($idProTran);
                $query->whereIn('id', $idProgramTran);
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
            "admin.pages.program.list",
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
        if ($request->has("parent_id")) {
            $htmlselect = $this->categoryProgram->getHtmlOptionAddWithParent($request->parent_id);
        } else {
            $htmlselect = $this->categoryProgram->getHtmlOption();
        }
        $htmlselect = $this->categoryProgram->getHtmlOption();
        return view("admin.pages.program.add",
            [
                'option' => $htmlselect,
                'request' => $request
            ]
        );
    }
    public function store(ValidateAddProgram $request)
    {

        // dd($request->all());
        try {
            DB::beginTransaction();
            //  dd($request->all());
            $dataProgramCreate = [
                "hot" => $request->input('hot') ?? 0,
                "view" => $request->input('view') ?? 0,
                "order" => $request->input('order') ?? null,
                "time" => $request->input('time') ?? null,
                "active" => $request->input('active'),
                "category_id" => $request->input('category_id'),
                "admin_id" => auth()->guard('admin')->id()
            ];
            $dataUploadAvatar = $this->storageTraitUpload($request, "avatar_path", "program");
            if (!empty($dataUploadAvatar)) {
                $dataProgramCreate["avatar_path"] = $dataUploadAvatar["file_path"];
            }

            // insert database in programs table
            $program = $this->program->create($dataProgramCreate);
            //  dd($program);
            // insert data product lang
            $dataProgramTranslation = [];
            //  dd($this->langConfig);
            foreach ($this->langConfig as $key => $value) {
                $itemProgramTranslation = [];
                $itemProgramTranslation['name'] = $request->input('name_' . $key);
                $itemProgramTranslation['slug'] = $request->input('slug_' . $key);
                $itemProgramTranslation['description'] = $request->input('description_' . $key);
                $itemProgramTranslation['description_seo'] = $request->input('description_seo_' . $key);
                $itemProgramTranslation['title_seo'] = $request->input('title_seo_' . $key);
                $itemProgramTranslation['keyword_seo'] = $request->input('keyword_seo_' . $key);
                $itemProgramTranslation['content'] = $request->input('content_' . $key);
                $itemProgramTranslation['content2'] = $request->input('content2_' . $key);
                $itemProgramTranslation['content3'] = $request->input('content3_' . $key);
                $itemProgramTranslation['content4'] = $request->input('content4_' . $key);
                $itemProgramTranslation['language'] = $key;
                //  dd($itemProgramTranslation);
                $dataProgramTranslation[] = $itemProgramTranslation;
            }
            //  dd($dataProgramTranslation);
            // dd($program->translations());
            $programTranslation =   $program->translations()->createMany($dataProgramTranslation);
            // dd($programTranslation);
            // insert database to program_tags table

            foreach ($this->langConfig as $key => $value) {
                if ($request->has("tags_" . $key)) {
                    $tag_ids = [];
                    foreach ($request->input('tags_' . $key) as $tagItem) {
                        $tagInstance = $this->tag->firstOrCreate(["name" => $tagItem]);
                        $tag_ids[] = $tagInstance->id;
                    }
                    $program->tags()->attach($tag_ids, ['language' => $key]);
                }
            }
            if ($request->has('typeParagraph')) {
                $dataParagraphCreate = [];
                foreach ($request->input('typeParagraph') as $key => $typeParagraph) {
                    if ($typeParagraph) {
                        $dataParagraphCreateItem = [];
                        $dataParagraphCreateItem = [
                            "active" => $request->input('activeParagraph')[$key],
                            "type" => $typeParagraph,
                            "parent_id" => $request->input('parentIdParagraph')[$key] ?? 0,
                            "order" => $request->input('orderParagraph')[$key] ?? 0,
                            "admin_id" => auth()->guard('admin')->id()
                        ];

                        //  dd(count($request->image_path_paragraph));
                        //dd($request->hasFile('image_path_paragraph[0]'));
                        $dataUploadParagraphAvatar = $this->storageTraitUploadMutipleArray($request, "image_path_paragraph", $key, "program");
                        if (!empty($dataUploadParagraphAvatar)) {
                            $dataParagraphCreateItem["image_path"] = $dataUploadParagraphAvatar["file_path"];
                        }
                        $dataParagraphCreate[] = $dataParagraphCreateItem;
                        $paragraphProgram = $program->paragraphs()->create(
                            $dataParagraphCreateItem
                        );

                        // insert data paragraph lang
                        $dataParagraphTranslation = [];
                        //  dd($this->langConfig);
                        foreach ($this->langConfig as $keyL => $valueL) {
                            $itemParagraphTranslation = [];
                            $itemParagraphTranslation['name'] = $request->input('nameParagraph_' . $keyL)[$key];
                            $itemParagraphTranslation['value'] = $request->input('valueParagraph_' . $keyL)[$key];
                            $itemParagraphTranslation['language'] = $keyL;
                            //  dd($itemProgramTranslation);
                            $dataParagraphTranslation[] = $itemParagraphTranslation;
                        }
                        // dd($dataParagraphTranslation);
                        $paragraphProgramTranslation =   $paragraphProgram->translations()->createMany($dataParagraphTranslation);
                        //  dd($paragraphProgramTranslation);

                        // $program->paragraphs()->attach($paragraphProgram->id);

                        //  dd($program->paragraphs);

                        //dd($dataParagraphCreateItem);
                        //   $tagInstance = $this->paragraphProgram->firstOrCreate($dataParagraphCreateItem);
                    }
                }
                // dd($dataParagraphCreate);
                //   dd($dataProductAnswerCreate);
                // insert database in product_images table by createMany
            }
            //     dd($program->paragraphs);
            DB::commit();
            return redirect()->route('admin.program.index')->with("alert", "Thêm bài viết thành công");
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.program.index')->with("error", "Thêm bài viết không thành công");
        }
    }
    public function edit($id)
    {

        $data = $this->program->find($id);
        $category_id = $data->category_id;
        $htmlselect = $this->categoryProgram->getHtmlOption($category_id);
        return view("admin.pages.program.edit", [
            'option' => $htmlselect,
            'data' => $data,
            'configParagraph' => $this->configParagraph
        ]);
    }
    public function update(ValidateEditProgram $request, $id)
    {

        try {
            DB::beginTransaction();
            $dataProgramUpdate = [
                "order" => $request->input('order') ?? null,
                "time" => $request->input('time') ?? null,
                "hot" => $request->input('hot') ?? 0,
                "active" => $request->input('active'),
                "category_id" => $request->input('category_id'),
                "admin_id" => auth()->guard('admin')->id(),
            ];
            $dataUploadAvatar = $this->storageTraitUpload($request, "avatar_path", "program");
            if (!empty($dataUploadAvatar)) {
                $path = $this->program->find($id)->avatar_path;
                if ($path) {
                    Storage::delete($this->makePathDelete($path));
                }
                $dataProgramUpdate["avatar_path"] = $dataUploadAvatar["file_path"];
            }
            // insert database in program table
            $this->program->find($id)->update($dataProgramUpdate);
            $program = $this->program->find($id);

            // insert data product lang
            $dataProgramTranslationUpdate = [];
            foreach ($this->langConfig as $key => $value) {
                $itemProgramTranslationUpdate = [];
                $itemProgramTranslationUpdate['name'] = $request->input('name_' . $key);
                $itemProgramTranslationUpdate['slug'] = $request->input('slug_' . $key);
                $itemProgramTranslationUpdate['description'] = $request->input('description_' . $key);
                $itemProgramTranslationUpdate['description_seo'] = $request->input('description_seo_' . $key);
                $itemProgramTranslationUpdate['title_seo'] = $request->input('title_seo_' . $key);
                $itemProgramTranslationUpdate['keyword_seo'] = $request->input('keyword_seo_' . $key);
                $itemProgramTranslationUpdate['content'] = $request->input('content_' . $key);
                $itemProgramTranslationUpdate['content2'] = $request->input('content2_' . $key);
                $itemProgramTranslationUpdate['content3'] = $request->input('content3_' . $key);
                $itemProgramTranslationUpdate['content4'] = $request->input('content4_' . $key);
                $itemProgramTranslationUpdate['language'] = $key;

                if ($program->translationsLanguage($key)->first()) {
                    $program->translationsLanguage($key)->first()->update($itemProgramTranslationUpdate);
                } else {
                    $program->translationsLanguage($key)->create($itemProgramTranslationUpdate);
                }
            }

            // insert database to program_tags table

            $tag_ids = [];
            foreach ($this->langConfig as $key => $value) {

                if ($request->has("tags_" . $key)) {
                    foreach ($request->input('tags_' . $key) as $tagItem) {
                        $tagInstance = $this->tag->firstOrCreate(["name" => $tagItem]);
                        $tag_ids[$tagInstance->id] = ['language' => $key];
                    }
                    //   $product->tags()->attach($tag_ids, ['language' => $key]);
                    // Các syncphương pháp chấp nhận một loạt các ID để ra trên bảng trung gian. Bất kỳ ID nào không nằm trong mảng đã cho sẽ bị xóa khỏi bảng trung gian.
                }
            }
            // dd($tag_ids);
            $program->tags()->sync($tag_ids);

            DB::commit();
            return redirect()->route('admin.program.index')->with("alert", "sửa  thành công");
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.program.index')->with("error", "Sửa  không thành công");
        }
    }
    public function destroy($id)
    {
        return $this->deleteTrait($this->program, $id);
    }

    public function loadActive($id)
    {
        $program   =  $this->program->find($id);
        $active = $program->active;
        if ($active) {
            $activeUpdate = 0;
        } else {
            $activeUpdate = 1;
        }
        $updateResult =  $program->update([
            'active' => $activeUpdate,
        ]);
        $program   =  $this->program->find($id);
        if ($updateResult) {
            return response()->json([
                "code" => 200,
                "html" => view('admin.components.load-change-active', ['data' => $program, 'type' => 'Chương trình'])->render(),
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
        $program   =  $this->program->find($id);
        $hot = $program->hot;

        if ($hot) {
            $hotUpdate = 0;
        } else {
            $hotUpdate = 1;
        }
        $updateResult =  $program->update([
            'hot' => $hotUpdate,
        ]);

        $program   =  $this->program->find($id);
        if ($updateResult) {
            return response()->json([
                "code" => 200,
                "html" => view('admin.components.load-change-hot', ['data' => $program, 'type' => 'Chương trình'])->render(),
                "message" => "success"
            ], 200);
        } else {
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }
    }

    public function excelExportDatabase()
    {
        return Excel::download(new ExcelExportsDatabase(config('excel_database.program')), config('excel_database.program.excelfile'));
    }
    public function excelImportDatabase()
    {
        $path = request()->file('fileExcel')->getRealPath();
        Excel::import(new ExcelImportsDatabase(config('excel_database.program')), $path);
    }

    // thêm sửa xóa đoạn văn
    public function loadParagraphProgram(Request $request)
    {
        return $this->loadParagraph($request, $this->configParagraph);
    }

    public function loadParentParagraphProgram($id, Request $request)
    {
        return $this->loadParentParagraph($this->program, $this->paragraphProgram, $id, $request);
    }

    public function loadCreateParagraphProgram($id)
    {
        return  $this->loadCreateParagraph($this->program, $id, $this->configParagraph);
    }
    public function loadEditParagraphProgram($id, Request $request)
    {
        return   $this->loadEditParagraph($this->paragraphProgram, $this->configParagraph, $id);
    }

    public function storeParagraphProgram(Request $request, $id)
    {
        return $this->storeParagraph($this->program, $this->configParagraph, $id,  $request);
    }
    public function updateParagraphProgram(Request $request, $id)
    {
        return $this->updateParagraph($this->paragraphProgram, $this->configParagraph, $id,  $request);
    }
    public function destroyParagraphProgram($id)
    {
        return $this->deleteCategoryRecusiveTrait($this->paragraphProgram, $id);
    }
    // end thêm sửa xóa đoạn văn

    // xử lý exercise

    public function loadCreateExercise($id, Request $request)
    {
        $dataView = [];
        $dataView['typeExercise'] = $request->type;
        $program = $this->program->find($id);
        // dd($paragraphProgram->program()->get());
        $dataView['program'] = $program;
        if ($program) {
            return response()->json([
                "code" => 200,
                "html" =>  view('admin.components.program.add-ajax-exercise', $dataView)->render(),
                "message" => "success"
            ], 200);
        } else {
            return response()->json([
                "code" => 500,
                "message" => "error"
            ], 500);
        }
    }

    public function loadCreateExerciseAnswer(Request $request)
    {
        return response()->json([
            "code" => 200,
            "html" =>  view('admin.components.program.add-exercise-answer', [])->render(),
            "message" => "success"
        ], 200);
    }

    public function storeExercise(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "nameExercise" => "required",
            "typeExercise" => "required",
            "nameAnswer.*" => "required",
            "codeAnswer.*" => "required"
        ]);

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
                $program = $this->program->find($id);
                $dataExerciseCreate = [
                    "title" => $request->input('titleExercise') ?? null,
                    "name" => $request->input('nameExercise') ?? null,
                    "order" => $request->input('orderExercise') ?? 0,
                    "answer" => $request->input('answerExercise') ?? null,
                    "type" => $request->input('typeExercise'),
                    "active" => $request->input('activeExercise'),
                    "admin_id" => auth()->guard('admin')->id()
                ];

                $exercise = $program->exercises()->create($dataExerciseCreate);

                // insert database to product_images table
                if ($request->has("codeAnswer")) {
                    //
                    $dataExerciseAnswerCreate = [];
                    foreach ($request->input('codeAnswer') as $key => $value) {
                        if ($value || $request->input('nameAnswer')[$key]) {
                            $dataExerciseAnswerCreate[] = [
                                "code" => $value,
                                "name" => $request->input('nameAnswer')[$key],
                                "correct" => $request->input('correctAnswer')[$key],
                                "admin_id" => auth()->guard('admin')->id()
                            ];
                        }
                    }

                    // insert database in exercise_answers table by createMany
                    $exercise->answers()->createMany($dataExerciseAnswerCreate);
                }

                DB::commit();
                return response()->json([
                    'code' => 200,
                    'html' => view('admin.components.program.load-list-exercise', [
                        'data' => $program,
                        'type' => config('web_default.typeExercise'),
                        'typeActive' => $exercise->type,
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

    public function loadEditExercise($id, Request $request)
    {

        $exercise = $this->exercise->find($id);
        // dd($paragraphProgram->program()->get());
        $dataView['data'] = $exercise;

        if ($exercise) {
            return response()->json([
                "code" => 200,
                "html" =>  view('admin.components.program.edit-ajax-exercise', $dataView)->render(),
                "message" => "success"
            ], 200);
        } else {
            return response()->json([
                "code" => 500,
                "message" => "error"
            ], 500);
        }
    }


    public function updateExercise(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "nameExercise" => "required",
            "typeExercise" => "required",
        ]);
        if ($validator->passes()) {
            try {
                DB::beginTransaction();
                $dataExerciseUpdate = [
                    "title" => $request->input('titleExercise') ?? null,
                    "name" => $request->input('nameExercise') ?? null,
                    "order" => $request->input('orderExercise') ?? 0,
                    "answer" => $request->input('answerExercise') ?? null,
                    "type" => $request->input('typeExercise'),
                    "active" => $request->input('activeExercise'),
                    "admin_id" => auth()->guard('admin')->id()
                ];

                $this->exercise->find($id)->update($dataExerciseUpdate);

                $exercise = $this->exercise->find($id);
                DB::commit();
                return response()->json([
                    'code' => 200,
                    'html' => view('admin.components.program.load-list-exercise', [
                        'data' => $exercise->program,
                        'type' => config('web_default.typeExercise'),
                        'typeActive' => $exercise->type,
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
    public function destroyExercise($id)
    {
        return $this->deleteTrait($this->exercise, $id);
    }
    public function loadEditAnswer($id)
    {
        $exerciseAnswer = $this->exerciseAnswer->find($id);
        // dd($paragraphProgram->program()->get());
        $dataView['data'] = $exerciseAnswer;

        if ($exerciseAnswer) {
            return response()->json([
                "code" => 200,
                "html" =>  view('admin.components.program.edit-ajax-exercise-answer', $dataView)->render(),
                "message" => "success"
            ], 200);
        } else {
            return response()->json([
                "code" => 500,
                "message" => "error"
            ], 500);
        }
    }

    public function updateExerciseAnswer($id, Request $request)
    {


        $validator = Validator::make($request->all(), [
            "codeAnswer" => "required",
            "nameAnswer" => "required",
        ]);

        if ($request->has('correctAnswer') && !$request->input('correctAnswer')) {
            $validator->after(function ($validator) {
                $idA = request()->route()->parameter('id');
                $a = \App\Models\ExerciseAnswer::find($idA);
                $q = $a->exercise;

                if ($q->answers()->where([
                    ['correct', 1],
                    ['id', '<>', $idA]
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
            $exerciseAnswer = $this->exerciseAnswer->find($id);
            try {
                DB::beginTransaction();
                $dataExerciseAnswerUpdate = [
                    "code" => $request->input('codeAnswer') ?? null,
                    "name" => $request->input('nameAnswer') ?? null,
                    "order" => $request->input('orderAnswer') ?? 0,
                    "correct" => $request->input('correctAnswer') ?? 0,
                    "admin_id" => auth()->guard('admin')->id()
                ];

                $this->exerciseAnswer->find($id)->update($dataExerciseAnswerUpdate);

                $exerciseAnswer = $this->exerciseAnswer->find($id);
                DB::commit();
                return response()->json([
                    'code' => 200,
                    'html' => view('admin.components.program.load-list-exercise', [
                        'data' => $exerciseAnswer->exercise->program,
                        'type' => config('web_default.typeExercise'),
                        'typeActive' => $exerciseAnswer->exercise->type,
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


    public function loadCreateNowExerciseAnswer($id, Request $request)
    {
        $exercise = $this->exercise->find($id);
        return response()->json([
            "code" => 200,
            "html" =>  view('admin.components.program.add-ajax-exercise-answer', ['data' => $exercise])->render(),
            "message" => "success"
        ], 200);
    }

    public function storeExerciseAnswer(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "codeAnswer" => "required",
            "nameAnswer" => "required",
            "orderAnswer" => "nullable|numeric"
        ]);
        if ($request->has('correctAnswer') && !$request->input('correctAnswer')) {
            $validator->after(function ($validator) {
                $idQ = request()->route()->parameter('id');
                $q = \App\Models\Exercise::find($idQ);
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
                $exercise = $this->exercise->find($id);
                $dataExerciseAnswerCreate = [
                    "code" => $request->input('codeAnswer') ?? null,
                    "name" => $request->input('nameAnswer') ?? null,
                    "order" => $request->input('orderAnswer') ?? 0,
                    "correct" => $request->input('correctAnswer') ?? 0,
                    "admin_id" => auth()->guard('admin')->id()
                ];
                $exercise->answers()->create($dataExerciseAnswerCreate);

                DB::commit();
                return response()->json([
                    'code' => 200,
                    'html' => view('admin.components.program.load-list-exercise', [
                        'data' => $exercise->program,
                        'type' => config('web_default.typeExercise'),
                        'typeActive' => $exercise->type,
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

        $answer = $this->exerciseAnswer->find($id);
        if ($answer->correct) {

            $exercise = $answer->exercise;

            if ($exercise->answers()->where([
                ['correct', 1],
                ['id', '<>', $id]
            ])->count() <= 0) {
                return response()->json([
                    "code" => 500,
                    "message" => "Đây là đáp án đúng. Bạn phải chọn 1 đáp án đúng cho câu hỏi này trước khi xóa"
                ], 200);
            } else {
                return $this->deleteTrait($this->exerciseAnswer, $id);
            }
        } else {
            return $this->deleteTrait($this->exerciseAnswer, $id);
        }
    }
}
