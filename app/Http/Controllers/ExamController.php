<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\CategoryExam;
use App\Models\ExamTranslation;
use App\Models\CategoryExamTranslation;
use App\Models\Task;
use App\Models\TaskAnswer;
use App\Models\TaskAnswerChoice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class ExamController extends Controller
{
    //
    private $exam;
    private $categoryExam;
    private $task;
    private $taskAnswer;
    private $taskAnswerChoice;
    private $limitExam = 10;
    private $limitExamRelate = 5;
    private $idCategoryExamRoot = 1;
    private $examTranslation;
    private $categoryExamTranslation;
    private $breadcrumbFirst = [];
    public function __construct(
        Exam $exam,
        CategoryExam $categoryExam,
        ExamTranslation $examTranslation,
        CategoryExamTranslation $categoryExamTranslation,
        Task $task,
        TaskAnswer $taskAnswer,
        TaskAnswerChoice $taskAnswerChoice
    ) {
        $this->exam = $exam;
        $this->categoryExam = $categoryExam;
        $this->examTranslation = $examTranslation;

        $this->task = $task;
        $this->taskAnswer = $taskAnswer;
        $this->taskAnswerChoice = $taskAnswerChoice;

        $this->categoryExamTranslation = $categoryExamTranslation;
        $this->breadcrumbFirst = [
            'name' => 'Đề thi',
            'slug' => makeLink("exam_index"),
            'id' => null,
        ];
    }
    public function index(Request $request)
    {
        $breadcrumbs = [];
        $data = [];
        // get category
        $category = $this->categoryExam->where([
            ['id', $this->idCategoryExamRoot],
        ])->first();
        if ($category) {
            if ($category->count()) {
                $categoryId = $category->id;
                $listIdChildren = $this->categoryExam->getALlCategoryChildrenAndSelf($categoryId);

                //   $data =  $this->exam->whereIn('category_id', $listIdChildren)->paginate($this->limitExam);
                $breadcrumbs[] = $this->categoryExam->select('id')->find($this->idCategoryExamRoot);
                if ($category->childs()->where('active', 1)->count() > 0) {
                    $data = $category->childs()->where('active', 1)->orderby('order')->orderByDesc('created_at')->paginate($this->limitExam);
                    $typeView = 'category';
                } else {
                    $data =  $this->exam->whereIn('category_id', $listIdChildren)->paginate($this->limitExam);
                    $typeView = 'category-exam';
                }

                $listIdActive = [];
                $categoryExamSidebar = $this->categoryExam->whereIn(
                    'id',
                    [$this->idCategoryExamRoot]
                )->get();
                //  dd($category);
                return view('frontend.pages.category-exam', [
                    'data' => $data,
                    'breadcrumbs' => $breadcrumbs,
                    'typeBreadcrumb' => 'exam_index',
                    'category' => $category,
                    'categoryExam' => $categoryExamSidebar,
                    'typeView' => $typeView,
                    'categoryExamActive'=>$listIdActive,
                    'seo' => [
                        'title' =>  $category->title_seo ?? "",
                        'keywords' =>  $category->keywords_seo ?? "",
                        'description' =>  $category->description_seo ?? "",
                        'image' => $category->avatar_path ?? "",
                        'abstract' =>  $category->description_seo ?? "",
                    ]
                ]);
            }
        }
    }

    // danh sách product theo category
    public function examByCategory($slug)
    {
        // dd(route('product.index',['category'=>$request->category]));
        $breadcrumbs = [];
        $data = [];

        $translation = $this->categoryExamTranslation->where([
            ['slug', $slug],
        ])->first();


        if ($translation) {
            if ($translation->count()) {
                $category = $translation->category;
                if (checkRouteLanguage($slug, $category)) {
                    return checkRouteLanguage($slug, $category);
                }

                if ($category) {
                    if ($category->count()) {
                        $categoryId = $category->id;
                        $listIdChildren = $this->categoryExam->getALlCategoryChildrenAndSelf($categoryId);
                        //dd($listIdChildren);
                        if ($category->childs()->where('active', 1)->count() > 0) {
                            $data = $category->childs()->where('active', 1)->orderby('order')->orderByDesc('created_at')->paginate($this->limitExam);
                            $typeView = 'category';
                        } else {
                            $data =  $this->exam->whereIn('category_id', $listIdChildren)->paginate($this->limitExam);
                            $typeView = 'category-exam';
                        }

                        $listIdParent = $this->categoryExam->getALlCategoryParentAndSelf($categoryId);

                        // lấy list danh mục active
                        $listIdActive = $listIdParent;
                        $categoryExamSidebar = $this->categoryExam->whereIn(
                            'id',
                            [$this->idCategoryExamRoot]
                        )->get();
                        foreach ($listIdParent as $parent) {
                            $breadcrumbs[] = $this->categoryExam->select('id')->find($parent);
                        }
                        return view('frontend.pages.category-exam', [
                            'data' => $data,
                            'typeView' => $typeView,
                            'breadcrumbs' => $breadcrumbs,
                            'categoryExam' => $categoryExamSidebar,
                            'categoryExamActive'=>$listIdActive,
                            'typeBreadcrumb' => 'category_exams',
                            'category' => $category,
                            'seo' => [
                                'title' =>  $category->title_seo ?? "",
                                'keywords' =>  $category->keywords_seo ?? "",
                                'description' =>  $category->description_seo ?? "",
                                'image' => $category->avatar_path ?? "",
                                'abstract' =>  $category->description_seo ?? "",
                            ]
                        ]);
                    }
                }
            }
        }
    }

    public function detail($slug)
    {
        $breadcrumbs = [];
        $data = [];
        $translation = $this->examTranslation->where([
            ["slug", $slug],
        ])->first();
        if ($translation) {
            $data = $translation->exam;

            if (checkRouteLanguage($slug, $data)) {
                return checkRouteLanguage($slug, $data);
            }

            $categoryId = $data->category_id;
            $listIdChildren = $this->categoryExam->getALlCategoryChildrenAndSelf($categoryId);
            $dataRelate =  $this->exam->whereIn('category_id', $listIdChildren)->where([
                ["id", "<>", $data->id],
            ])->limit($this->limitExamRelate)->get();
            $listIdParent = $this->categoryExam->getALlCategoryParentAndSelf($categoryId);
            // lấy list danh mục active
            $listIdActive = $listIdParent;
            // dd($categoryNew);
            foreach ($listIdParent as $parent) {
                $breadcrumbs[] = $this->categoryExam->select('id')->find($parent);
            }

            // lấy sidebar
            $categoryExamSidebar = $this->categoryExam->whereIn(
                'id',
                [$this->idCategoryExamRoot]
            )->get();

            return view('frontend.pages.exam-detail', [
                'data' => $data,
                'categoryExam' => $categoryExamSidebar,
                'categoryExamActive'=>$listIdActive,

                "dataRelate" => $dataRelate,
                'breadcrumbs' => $breadcrumbs,
                'typeBreadcrumb' => 'category_exams',
                'title' => $data ? $data->name : "",
                'category' => $data->category ?? null,
                'seo' => [
                    'title' =>  $data->title_seo ?? "",
                    'keywords' =>  $data->keywords_seo ?? "",
                    'description' =>  $data->description_seo ?? "",
                    'image' => $data->avatar_path ?? "",
                    'abstract' =>  $data->description_seo ?? "",
                ]
            ]);
        }
    }
    public function doExam($slug)
    {
        $breadcrumbs = [];
        $data = [];
        $translation = $this->examTranslation->where([
            ["slug", $slug],
        ])->first();
        if ($translation) {
            $data = $translation->exam;

            if (checkRouteLanguage($slug, $data)) {
                return checkRouteLanguage($slug, $data);
            }

            $categoryId = $data->category_id;
            $listIdChildren = $this->categoryExam->getALlCategoryChildrenAndSelf($categoryId);
            $dataRelate =  $this->exam->whereIn('category_id', $listIdChildren)->where([
                ["id", "<>", $data->id],
            ])->limit($this->limitExamRelate)->get();
            $listIdParent = $this->categoryExam->getALlCategoryParentAndSelf($categoryId);

            // dd($categoryNew);
            foreach ($listIdParent as $parent) {
                $breadcrumbs[] = $this->categoryExam->select('id')->find($parent);
            }

            // lấy sidebar
            $categoryExamSidebar = $this->categoryExam->whereIn(
                'parent_id',
                [$this->idCategoryExamRoot]
            )->get();
            return view('frontend.pages.exam-do', [
                'data' => $data,
                'categoryExamSidebar' => $categoryExamSidebar,
                "dataRelate" => $dataRelate,
                'breadcrumbs' => $breadcrumbs,
                'typeBreadcrumb' => 'category_exams',
                'title' => $data ? $data->name : "",
                'category' => $data->category ?? null,
                'seo' => [
                    'title' =>  $data->title_seo ?? "",
                    'keywords' =>  $data->keywords_seo ?? "",
                    'description' =>  $data->description_seo ?? "",
                    'image' => $data->avatar_path ?? "",
                    'abstract' =>  $data->description_seo ?? "",
                ]
            ]);
        }
    }

    public function storeResultExam($slug, Request $request)
    {
        $translation = $this->examTranslation->where([
            ["slug", $slug],
        ])->first();

        if ($translation) {
            if ($translation->count()) {
                $exam = $translation->exam;
                $view =$exam->view;
                if($view){
                    $view++;
                }else{
                    $view=1;
                }
                $exam->update([
                    'view'=> $view
                ]);
                try {
                    DB::beginTransaction();
                    $user = Auth::guard('web')->user();

                    $dataTaskCreate = [
                        'exam_id' => $exam->id,
                        'user_id' => $user->id,
                        // 'point'=>1,
                        'active' => 1,
                    ];
                    $point = 0;
                    $totalQuestion = $exam->questions()->where('active', 1)->where('type', 1)->count();
                    $numberAnswerTrue = 0;
                    $task = $this->task->create($dataTaskCreate);
                    $dataTaskAnswerCreate = [];
                    //  dd($request->input('answer'));
                    if ($request->has('question')) {
                        foreach ($request->question as $key => $value) {
                            $dataTaskAnswerCreate = [
                                'question_id' => $value,
                                'answer' => null,
                                'type' => $request->type[$key],
                                //'answer_id' => $request->answer[$key] ? $request->answer[$key] : null,
                            ];
                            $taskAnswer =  $task->answers()->create($dataTaskAnswerCreate);
                            //   dd($taskAnswer->choices()->count());
                            //  dd($taskAnswer);
                            $dataChoiceCreate = [];
                            if (isset($request->answer[$key]) && $request->answer[$key]) {
                                if ($taskAnswer->checkAnswer($request->answer[$key])) {
                                    $numberAnswerTrue++;
                                }
                                foreach ($request->answer[$key] as $keyA => $choice) {
                                    $itemChoiceCreate = [
                                        'answer_id' => $choice
                                    ];
                                    $dataChoiceCreate[] = $itemChoiceCreate;
                                }
                                if ($dataChoiceCreate) {
                                    $taskAnswer->choices()->createMany($dataChoiceCreate);
                                }
                            }
                        }
                    }
                    if ($request->has('questionTL')) {
                        foreach ($request->questionTL as $key => $value) {
                            $dataDapanCreate[] = [
                                'question_id' => $value,
                                'answer' => $request->answerTL[$key] ? $request->answerTL[$key] : null,
                                'type' => $request->typeTL[$key],
                                'answer_id' => null,
                            ];
                        }
                    }
                    $point = $numberAnswerTrue / $totalQuestion * 10;
                    $task->update([
                        'point' => $point
                    ]);

                    DB::commit();
                    return redirect()->route('exam.resultExam', ['slug' => $slug, 'task_id' => $task->id])->with("alert", "Gửi bài thi thành công");
                } catch (\Exception $exception) {
                    DB::rollBack();
                    Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());

                    return redirect()->route('exam.doExam', ['slug' => $slug])->with("error", "Gửi bài thi không thành công");
                }
            }
        }
    }

    public function resultExam($slug, Request $request)
    {
        $breadcrumbs = [];
        $data = [];
        $user = Auth::guard('web')->user();
        $task_id = $request->task_id;
        $task = $user->tasks()->where('id', $task_id)->first();
        // dd($task);
        // $translation = $this->examTranslation->where([
        //     ["slug", $slug],
        // ])->first();
        if ($task) {
            $exam = $task->exam;
            $categoryId = $exam->category_id;
            $listIdChildren = $this->categoryExam->getALlCategoryChildrenAndSelf($categoryId);
            $dataRelate =  $this->exam->whereIn('category_id', $listIdChildren)->where([
                ["id", "<>", $exam->id],
            ])->limit($this->limitExamRelate)->get();
            $listIdParent = $this->categoryExam->getALlCategoryParentAndSelf($categoryId);

            // dd($categoryNew);
            foreach ($listIdParent as $parent) {
                $breadcrumbs[] = $this->categoryExam->select('id')->find($parent);
            }

            return view('frontend.pages.exam-result', [
                'data' => $task,
                'exam'=>$exam,
                "dataRelate" => $dataRelate,
                'breadcrumbs' => $breadcrumbs,
                'typeBreadcrumb' => 'category_exams',
                'title' => $exam ? $exam->name : "",
                'category' => $exam->category ?? null,
                'seo' => [
                    'title' =>  $exam->title_seo ?? "",
                    'keywords' =>  $exam->keywords_seo ?? "",
                    'description' =>  $exam->description_seo ?? "",
                    'image' => $exam->avatar_path ?? "",
                    'abstract' =>  $exam->description_seo ?? "",
                ]
            ]);
        }
    }
}
