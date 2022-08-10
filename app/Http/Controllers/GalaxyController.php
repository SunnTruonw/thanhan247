<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GalaxyTranslation;
use App\Models\Galaxy;
use App\Models\CategoryGalaxy;
use App\Models\CategoryGalaxyTranslation;

class GalaxyController extends Controller
{
    //
    private $galaxy;
    private $categoryGalaxy;
    private $galaxyTranslation;
    private $categoryGalaxyTranslation;
    private $idCategoryGalaxyRoot = 1;
    private $limitCategoryGalaxy = 10;
    private $limitGalaxyRelate = 20;
    private $limitGalaxy = 20;
    public function __construct(
        Galaxy $galaxy,
        CategoryGalaxy $categoryGalaxy,
        GalaxyTranslation $galaxyTranslation,
        CategoryGalaxyTranslation $categoryGalaxyTranslation
    ) {
        $this->galaxy = $galaxy;
        $this->categoryGalaxy = $categoryGalaxy;
        $this->galaxyTranslation = $galaxyTranslation;
        $this->categoryGalaxyTranslation = $categoryGalaxyTranslation;
        $this->breadcrumbFirst = [
            'name' => 'Video',
            'slug' => makeLink("galaxy_index"),
            'id' => null,
        ];
    }
    public function index(Request $request)
    {
        // dd(route('product.index',['category'=>$request->category]));
        $breadcrumbs = [];
        $data = [];
        // get category
        $category = $this->categoryGalaxy->mergeLanguage()->where([
            ['category_galaxies.id', $this->idCategoryGalaxyRoot],
        ])->first();
        if ($category) {
            if ($category->count()) {
                $categoryId = $category->id;
                $listIdChildren = $this->categoryGalaxy->getALlCategoryChildrenAndSelf($categoryId);
                //  $data =  $this->galaxy->whereIn('category_id', $listIdChildren)->paginate($this->limitGalaxy);
                $breadcrumbs[] = $this->categoryGalaxy->mergeLanguage()->find($this->idCategoryGalaxyRoot);

                $listIdActive = [];
                $categoryGalaxySidebar = $this->categoryGalaxy->whereIn(
                    'id',
                    [$this->idCategoryGalaxyRoot]
                )->get();

                if ($category->childLs()->where('category_galaxies.active', 1)->count() > 0) {
                    $data =  $category->childLs()->where([['category_galaxies.active', 1]])->orderby('order')->orderByDesc('created_at')->paginate($this->limitCategoryGalaxy);
                    $typeView = 'category';
                } else {
                    $data =  $this->galaxy->mergeLanguage()->whereIn('galaxies.category_id', $listIdChildren)->where('galaxies.active', 1)->orderby('order')->orderByDesc('created_at')->paginate($this->limitGalaxy);
                    $typeView = 'galaxy';
                }

                return view('frontend.pages.galaxy', [
                    'data' => $data,
                    'breadcrumbs' => $breadcrumbs,
                    'typeBreadcrumb' => 'galaxy_index',
                    'category' => $category,
                    'categoryGalaxy' => $categoryGalaxySidebar,
                    'typeView' => $typeView,
                    'categoryGalaxyActive' => $listIdActive,
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

    public function galaxyByCategory($slug)
    {
        // dd(route('product.index',['category'=>$request->category]));
        $breadcrumbs = [];
        $data = [];

        $translation = $this->categoryGalaxyTranslation->where([
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
                        $listIdChildren = $this->categoryGalaxy->getALlCategoryChildrenAndSelf($categoryId);
                        //  $data =  $this->galaxy->whereIn('category_id', $listIdChildren)->paginate($this->limitGalaxy);


                        /*if ($category->childLs()->where('category_galaxies.active', 1)->count() > 0) {
                            $datacate =  $category->childLs()->where([['category_galaxies.active', 1]])->orderby('order')->orderByDesc('created_at')->get();
                        }*/

                        $data =  $this->galaxy->mergeLanguage()->whereIn('galaxies.category_id', $listIdChildren)->where('galaxies.active', 1)->orderby('order')->orderByDesc('created_at')->paginate($this->limitGalaxy);


                        $dataAll =  $this->galaxy->mergeLanguage()->whereIn('galaxies.category_id', $listIdChildren)->where('galaxies.active', 1)->orderby('order')->orderByDesc('created_at')->get();

                        
                      //  $breadcrumbs[] = $this->categoryGalaxy->select('id')->find($this->idCategoryGalaxyRoot);

                        $categoryGalaxySidebar = $this->categoryGalaxy->whereIn(
                            'id',
                            [$this->idCategoryGalaxyRoot]
                        )->get();
                        $listIdParent = $this->categoryGalaxy->getALlCategoryParentAndSelf($categoryId);
                        // lấy category sidebar theo danh mục
                        $listIdActive = $listIdParent;
                        foreach ($listIdParent as $parent) {
                            $breadcrumbs[] = $this->categoryGalaxy->mergeLanguage()->find($parent);
                        }

                        return view('frontend.pages.galaxy-by-category', [
                            'data' => $data,
                            'dataAll' => $dataAll,
                            'breadcrumbs' => $breadcrumbs,
                            'typeBreadcrumb' => 'category_galaxies',
                            'category' => $category,
                            'categoryGalaxy' => $categoryGalaxySidebar,
                            'categoryGalaxyActive' => $listIdActive,
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
        $translation = $this->galaxyTranslation->where([
            ["slug", $slug],
        ])->first();
        if ($translation) {
            $data = $translation->galaxy;
            if( checkRouteLanguage($slug,$data)){
                return checkRouteLanguage($slug,$data);
            }
            $viewUpdate=$data->view;
            if($data->view){
                $viewUpdate++;
            }else{
                $viewUpdate=1;
            }
            $data->update([
                'view'=>$viewUpdate,
            ]);

            $categoryId = $data->category_id;

            $listIdChildren = $this->categoryGalaxy->getALlCategoryChildrenAndSelf($categoryId);

            $dataRelate =  $this->galaxy->mergeLanguage()->whereIn('galaxies.category_id', $listIdChildren)->where([
                ["galaxies.id", "<>", $data->id],
            ])->orderby('order')->orderByDesc('created_at')->limit($this->limitGalaxyRelate)->get();
            $listIdParent = $this->categoryGalaxy->getALlCategoryParentAndSelf($categoryId);
            // lấy category sidebar theo danh mục
            $listIdActive = $listIdParent;
            $categoryGalaxySidebar = $this->categoryGalaxy->whereIn(
                'id',
                [$this->idCategoryGalaxyRoot]
            )->get();
            foreach ($listIdParent as $parent) {
                $breadcrumbs[] = $this->categoryGalaxy->mergeLanguage()->find($parent);
            }

            //  dd($data->paragraphs);
            return view('frontend.pages.galaxy-detail', [
                'data' => $data,
                "dataRelate" => $dataRelate,
                'breadcrumbs' => $breadcrumbs,
                'typeBreadcrumb' => 'category_galaxies',
                'title' => $data ? $data->name : "",
                'category' => $data->category ?? null,
                'categoryGalaxy' => $categoryGalaxySidebar,
                'categoryGalaxyActive' => $listIdActive,
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

}
