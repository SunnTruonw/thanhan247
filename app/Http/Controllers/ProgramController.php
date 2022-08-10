<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\CategoryProgram;
use App\Models\ProgramTranslation;
use App\Models\CategoryProgramTranslation;
use App\Models\Exercise;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class ProgramController extends Controller
{
    //
    private $program;
    private $categoryProgram;
    private $exercise;
    private $limitProgram = 10;
    private $limitProgramRelate = 5;
    private $idCategoryProgramRoot = 4;
    private $programTranslation;
    private $categoryProgramTranslation;
    private $breadcrumbFirst = [];
    public function __construct(
        Program $program,
        CategoryProgram $categoryProgram,
        ProgramTranslation $programTranslation,
        CategoryProgramTranslation $categoryProgramTranslation,
        Exercise $exercise
    ) {
        $this->program = $program;
        $this->categoryProgram = $categoryProgram;
        $this->programTranslation = $programTranslation;
        $this->exercise = $exercise;
        $this->categoryProgramTranslation = $categoryProgramTranslation;
        $this->breadcrumbFirst = [
            'name' => 'Chương trình',
            'slug' => makeLink("program_index"),
            'id' => null,
        ];
    }
    public function index(Request $request)
    {
        $breadcrumbs = [];
        $data = [];
        // get category
        $category = $this->categoryProgram->where([
            ['id', $this->idCategoryProgramRoot],
        ])->first();
        if ($category) {
            if ($category->count()) {
                $categoryId = $category->id;
                $listIdChildren = $this->categoryProgram->getALlCategoryChildrenAndSelf($categoryId);

                //   $data =  $this->program->whereIn('category_id', $listIdChildren)->paginate($this->limitProgram);
                $breadcrumbs[] = $this->categoryProgram->select('id')->find($this->idCategoryProgramRoot);
                if ($category->childs()->where('active', 1)->count() > 0) {
                    $data = $category->childs()->where('active', 1)->orderby('order')->orderByDesc('created_at')->paginate($this->limitProgram);
                    $typeView = 'category';
                } else {
                    $data =  $this->program->whereIn('category_id', $listIdChildren)->paginate($this->limitProgram);
                    $typeView = 'category-program';
                }

                $listIdActive = [];
                $categoryProgramSidebar = $this->categoryProgram->whereIn(
                    'id',
                    [$this->idCategoryProgramRoot]
                )->get();
                //  dd($category);
                return view('frontend.pages.category-program', [
                    'data' => $data,
                    'breadcrumbs' => $breadcrumbs,
                    'typeBreadcrumb' => 'program_index',
                    'category' => $category,
                    'categoryProgram' => $categoryProgramSidebar,
                    'typeView' => $typeView,
                    'categoryProgramActive' => $listIdActive,
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
    public function programByCategory($slug)
    {
        // dd(route('product.index',['category'=>$request->category]));
        $breadcrumbs = [];
        $data = [];

        $translation = $this->categoryProgramTranslation->where([
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
                        $listIdChildren = $this->categoryProgram->getALlCategoryChildrenAndSelf($categoryId);
                        //dd($listIdChildren);
                        if ($category->childs()->where('active', 1)->count() > 0) {
                            $data = $category->childs()->where('active', 1)->orderby('order')->orderByDesc('created_at')->paginate($this->limitProgram);
                            $typeView = 'category';
                        } else {
                            $data =  $this->program->whereIn('category_id', $listIdChildren)->paginate($this->limitProgram);
                            $typeView = 'category-program';
                        }

                        $listIdParent = $this->categoryProgram->getALlCategoryParentAndSelf($categoryId);

                        // lấy list danh mục active
                        $listIdActive = $listIdParent;
                        $categoryProgramSidebar = $this->categoryProgram->whereIn(
                            'id',
                            [$this->idCategoryProgramRoot]
                        )->get();
                        foreach ($listIdParent as $parent) {
                            $breadcrumbs[] = $this->categoryProgram->select('id')->find($parent);
                        }
                        return view('frontend.pages.category-program', [
                            'data' => $data,
                            'typeView' => $typeView,
                            'breadcrumbs' => $breadcrumbs,
                            'categoryProgram' => $categoryProgramSidebar,
                            'categoryProgramActive' => $listIdActive,
                            'typeBreadcrumb' => 'category_programs',
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

    public function detail($slug, Request $request)
    {
        if ($request->has('type') && $request->has('activeType')) {
            $type = $request->input('type');
            $activeType = $request->input('activeType');
        } else {
            $type = null;
            $activeType = null;
        }
        //  dd($type,$typeActive);
        $breadcrumbs = [];
        $data = [];
        $translation = $this->programTranslation->where([
            ["slug", $slug],
        ])->first();
        //  dd($translation);
        if ($translation) {
            $data = $translation->program;
            if (checkRouteLanguage($slug, $data)) {
                return checkRouteLanguage($slug, $data);
            }
            //   dd( $data);
            $categoryId = $data->category_id;
            $listIdChildren = $this->categoryProgram->getALlCategoryChildrenAndSelf($categoryId);
            $dataRelate =  $this->program->whereIn('category_id', $listIdChildren)->where([
                ["id", "<>", $data->id],
            ])->limit($this->limitProgramRelate)->get();
            $listIdParent = $this->categoryProgram->getALlCategoryParentAndSelf($categoryId);
            // lấy list danh mục active
            $listIdActive = $listIdParent;
            // dd($categoryNew);
            foreach ($listIdParent as $parent) {
                $breadcrumbs[] = $this->categoryProgram->select('id')->find($parent);
            }

            // lấy sidebar
            $categoryProgramSidebar = $this->categoryProgram->whereIn(
                'id',
                [$this->idCategoryProgramRoot]
            )->get();

            return view('frontend.pages.program-detail', [
                'data' => $data,
                'categoryProgram' => $categoryProgramSidebar,
                'categoryProgramActive' => $listIdActive,
                'activeType' => $activeType,
                'type' => $type,
                "dataRelate" => $dataRelate,
                'breadcrumbs' => $breadcrumbs,
                'typeBreadcrumb' => 'category_programs',
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
    public function doExercise($slug)
    {
        $breadcrumbs = [];
        $data = [];
        $translation = $this->programTranslation->where([
            ["slug", $slug],
        ])->first();
        if ($translation) {
            $data = $translation->program;

            if (checkRouteLanguage($slug, $data)) {
                return checkRouteLanguage($slug, $data);
            }

            $categoryId = $data->category_id;
            $listIdChildren = $this->categoryProgram->getALlCategoryChildrenAndSelf($categoryId);
            $dataRelate =  $this->program->whereIn('category_id', $listIdChildren)->where([
                ["id", "<>", $data->id],
            ])->limit($this->limitProgramRelate)->get();
            $listIdParent = $this->categoryProgram->getALlCategoryParentAndSelf($categoryId);
            $listIdActive = $listIdParent;
            // dd($categoryNew);
            foreach ($listIdParent as $parent) {
                $breadcrumbs[] = $this->categoryProgram->select('id')->find($parent);
            }

            // lấy sidebar
            $categoryProgramSidebar = $this->categoryProgram->whereIn(
                'parent_id',
                [$this->idCategoryProgramRoot]
            )->get();
            return view('frontend.pages.program-do', [
                'data' => $data,
                'categoryProgram' => $categoryProgramSidebar,
                'categoryProgramActive' => $listIdActive,
                'activeType' => 'exercise',
                'type' => 1,
                "dataRelate" => $dataRelate,
                'breadcrumbs' => $breadcrumbs,
                'typeBreadcrumb' => 'category_programs',
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

    public function storeResultExercise($slug, Request $request)
    {
        $translation = $this->programTranslation->where([
            ["slug", $slug],
        ])->first();

        if ($translation) {

            $program = $translation->program;

            // $view = $program->view;
            // if ($view) {
            //     $view++;
            // } else {
            //     $view = 1;
            // }
            // $program->update([
            //     'view' => $view
            // ]);
            try {
                DB::beginTransaction();
                // $user = Auth::guard('web')->user();

                // $dataTaskCreate = [
                //     'program_id' => $program->id,
                //     'user_id' => $user->id,
                //     'active' => 1,
                // ];
                // $point = 0;
                $totalExercise = $program->exercises()->where('active', 1)->where('type', 1)->count();
                $numberAnswerTrue = 0;
                // $task = $this->task->create($dataTaskCreate);
                //  $dataTaskAnswerCreate = [];
                //  dd($request->input('answer'));
                if ($request->has('exercise')) {
                    foreach ($request->exercise as $key => $value) {
                        // $dataTaskAnswerCreate = [
                        //     'exercise_id' => $value,
                        //     'answer' => null,
                        //     'type' => $request->type[$key],
                        // ];
                        // $taskAnswer =  $task->answers()->create($dataTaskAnswerCreate);
                        //   dd($taskAnswer->choices()->count());
                        //  dd($taskAnswer);
                        //  $dataChoiceCreate = [];
                        $exercise = $this->exercise->find($value);
                        //  dd($exercise);
                        if (isset($request->answer[$key]) && $request->answer[$key]) {
                            if ($exercise->checkAnswer($request->answer[$key])) {
                                $numberAnswerTrue++;
                            }
                            // foreach ($request->answer[$key] as $keyA => $choice) {
                            //     $itemChoiceCreate = [
                            //         'answer_id' => $choice
                            //     ];
                            //     $dataChoiceCreate[] = $itemChoiceCreate;
                            // }
                            // if ($dataChoiceCreate) {
                            //     $taskAnswer->choices()->createMany($dataChoiceCreate);
                            // }
                        }
                    }
                }


                // $point = $numberAnswerTrue / $totalExercise ;
                // $task->update([
                //     'point' => $point
                // ]);

                DB::commit();
                return redirect()->route('program.detail', ['slug' => $slug,'type'=>1,'activeType'=>'exercise'])->with("resultDoExercise", "Bạn làm đúng " . $numberAnswerTrue . '/' . $totalExercise . ' câu');
            } catch (\Exception $exception) {
                DB::rollBack();
                Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());

                return redirect()->route('program.detail', ['slug' => $slug,'type'=>1,'activeType'=>'exercise'])->with("error", "Gửi bài làm không thành công");
            }
        }
    }

    public function resultExercise($slug, Request $request)
    {
        $breadcrumbs = [];
        $data = [];
        $user = Auth::guard('web')->user();
        $task_id = $request->task_id;
        $task = $user->tasks()->where('id', $task_id)->first();
        // dd($task);
        // $translation = $this->programTranslation->where([
        //     ["slug", $slug],
        // ])->first();
        if ($task) {
            $program = $task->program;
            $categoryId = $program->category_id;
            $listIdChildren = $this->categoryProgram->getALlCategoryChildrenAndSelf($categoryId);
            $dataRelate =  $this->program->whereIn('category_id', $listIdChildren)->where([
                ["id", "<>", $program->id],
            ])->limit($this->limitProgramRelate)->get();
            $listIdParent = $this->categoryProgram->getALlCategoryParentAndSelf($categoryId);

            // dd($categoryNew);
            foreach ($listIdParent as $parent) {
                $breadcrumbs[] = $this->categoryProgram->select('id')->find($parent);
            }

            return view('frontend.pages.program-result', [
                'data' => $task,
                'program' => $program,
                "dataRelate" => $dataRelate,
                'breadcrumbs' => $breadcrumbs,
                'typeBreadcrumb' => 'category_programs',
                'title' => $program ? $program->name : "",
                'category' => $program->category ?? null,
                'seo' => [
                    'title' =>  $program->title_seo ?? "",
                    'keywords' =>  $program->keywords_seo ?? "",
                    'description' =>  $program->description_seo ?? "",
                    'image' => $program->avatar_path ?? "",
                    'abstract' =>  $program->description_seo ?? "",
                ]
            ]);
        }
    }
}
