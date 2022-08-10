<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faq;
use App\Models\FaqAnswer;
use App\Models\FaqAnswerLike;
use App\Models\CategoryProgram;
use App\Models\CategoryProgramTranslation;
class FaqController extends Controller
{
    //
    private $faq;
    private $faqAnswer;
    private $faqAnswerLike;
    private $categoryProgram;
    private $categoryProgramTranslation;
    private $idCategoryProgramRoot = 4;
    private $limitCategoryProgram = 30;
    private $limitFaq = 30;
    public function __construct(
        Faq $faq,
        FaqAnswer $faqAnswer,
        FaqAnswerLike $faqAnswerLike,
        CategoryProgram $categoryProgram,
        CategoryProgramTranslation $categoryProgramTranslation
    ) {
        $this->faq = $faq;
        $this->faqAnswers = $faqAnswer;
        $this->faqAnswerLike = $faqAnswerLike;
        $this->categoryProgram = $categoryProgram;
        $this->categoryProgramTranslation = $categoryProgramTranslation;
        $this->breadcrumbFirst = [
            'name' => 'Hỏi đáp',
            'slug' => makeLink("faq_index"),
            'id' => null,
        ];
    }

    public function index(Request $request)
    {
        // dd(route('product.index',['category'=>$request->category]));
        $breadcrumbs = [];
        $data = [];
        // get category
        $category = $this->categoryProgram->where([
            ['id', $this->idCategoryProgramRoot],
        ])->first();
        if ($category) {
            if ($category->count()) {
                $categoryId = $category->id;
                $listIdChildren = $this->categoryProgram->getALlCategoryChildrenAndSelf($categoryId,2);
                //  dd($listIdChildren);
                //  $data =  $this->galaxy->whereIn('category_id', $listIdChildren)->paginate($this->limitGalaxy);
                $breadcrumbs[] = $this->categoryProgram->select('id')->find($this->idCategoryProgramRoot);

                $listIdActive = [];
                $categoryFaqSidebar = $this->categoryProgram->whereIn(
                    'id',
                    [$this->idCategoryProgramRoot]
                )->get();
                $data =  $category->childs()->where([['active', 1]])->orderby('order')->orderByDesc('created_at')->paginate($this->limitCategoryProgram);
                return view('frontend.pages.faq', [
                    'data' => $data,
                    'breadcrumbs' => $breadcrumbs,
                    'typeBreadcrumb' => 'faq_index',
                    'category' => $category,
                    'categoryFaq' => $categoryFaqSidebar,

                    'categoryFaqActive' => $listIdActive,
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

    public function faqByCategory($slug)
    {
        $breadcrumbs = [];
        $data = [];
        // get category

        $translation = $this->categoryProgramTranslation->where([
            ['slug', $slug],
        ])->first();

        if ($translation) {
            $category=$translation->category;
            if ($category) {
                $categoryId = $category->id;
                $listIdChildren = $this->categoryProgram->getALlCategoryChildrenAndSelf($categoryId,2);
                $listIdParent = $this->categoryProgram->getALlCategoryParentAndSelf($categoryId);
                // lấy list danh mục active
                $listIdActive = $listIdParent;
                $categoryFaqSidebar = $this->categoryProgram->whereIn(
                    'id',
                    [$this->idCategoryProgramRoot]
                )->get();

                foreach ($listIdParent as $parent) {
                    $breadcrumbs[] = $this->categoryProgram->select('id')->find($parent);
                }

                $data =  $this->faq->whereIn('subject',$listIdChildren)->orderby('order')->orderByDesc('created_at')->paginate($this->limitCategoryProgram);
                return view('frontend.pages.faq-by-category', [
                    'data' => $data,
                    'breadcrumbs' => $breadcrumbs,
                    'typeBreadcrumb' => 'faq_index',
                    'category' => $category,
                    'categoryFaq' => $categoryFaqSidebar,

                    'categoryFaqActive' => $listIdActive,
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
