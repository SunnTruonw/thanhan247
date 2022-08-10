<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Str;
use App\Models\CategoryPost;
use App\Models\CategoryProduct;
use App\Models\PostTranslation;
use App\Models\CategoryPostTranslation;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    //

    private $post;
    private $categoryProduct;
    private $unit = 'đ';
    private $categoryPost;
    private $setting;
    private $limitPost = 10;
    private $limitPostRelate = 4;
    private $idCategoryPostRoot = 1;
    private $postTranslation;
    private $categoryPostTranslation;
    private $breadcrumbFirst = [];
    public function __construct(
        Post $post,
        CategoryPost $categoryPost,
        CategoryProduct $categoryProduct,
        PostTranslation $postTranslation,
        CategoryPostTranslation $categoryPostTranslation,
        Setting $setting
    ) {
        $this->post = $post;
        $this->categoryPost = $categoryPost;
        $this->categoryProduct = $categoryProduct;
        $this->postTranslation = $postTranslation;
        $this->categoryPostTranslation = $categoryPostTranslation;
        $this->setting = $setting;
        $this->breadcrumbFirst = [
            'name' => 'Tin tức',
            'slug' => makeLink("post_all"),
            'id' => null,
        ];
    }
    public function index(Request $request)
    {
        // dd(route('product.index',['category'=>$request->category]));
        $breadcrumbs = [];
        $data = [];
        // get category
        $category = $this->categoryPost->where([
            ['id', $this->idCategoryPostRoot],
        ])->first();
        if ($category) {
            if ($category->count()) {
                $categoryId = $category->id;
                $listIdChildren = $this->categoryPost->getALlCategoryChildrenAndSelf($categoryId);
                $createLatest = optional($this->post->whereIn('category_id', $listIdChildren)->where([['active', 1], ['status', 3]])->latest()->first())->created_at;
                $data =  $this->post->whereIn('category_id', $listIdChildren)->where([['active', 1], ['status', 3]])->latest()->paginate($this->limitPost);

                $breadcrumbs[] = $this->categoryPost->select('id')->find($this->idCategoryPostRoot);

                $listIdActive = [];
                $categoryPostSidebar = $this->categoryPost->whereIn(
                    'id',
                    [$this->idCategoryPostRoot]
                )->get();
                //  dd($category);
                $banner = $this->setting->find(122);
                return view('frontend.pages.post', [
                    'data' => $data,
                    'unit' => $this->unit,
                    'breadcrumbs' => $breadcrumbs,
                    'typeBreadcrumb' => 'post_index',
                    'category' => $category,
                    'categoryPost' => $categoryPostSidebar,
                    //'typeView' => $typeView,
                    'categoryPostActive' => $listIdActive,
                    'banner' => $banner,
                    'createLatest' => $createLatest,
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

    public function detail($slug)
    {
        $breadcrumbs = [];
        $data = [];
        $translation = $this->postTranslation->where([
            ["slug", $slug],
        ])->first();
        if ($translation) {
            $data = $translation->post;
            if (checkRouteLanguage($slug, $data)) {
                return checkRouteLanguage($slug, $data);
            }
            $viewUpdate = $data->view;
            if ($data->view) {
                $viewUpdate++;
            } else {
                $viewUpdate = 1;
            }
            $data->update([
                'view' => $viewUpdate,
            ]);

            $categoryId = $data->category_id;

            $listIdChildren = $this->categoryPost->getALlCategoryChildrenAndSelf($categoryId);
            $createLatest = optional($this->post->mergeLanguage()->whereIn('posts.category_id', $listIdChildren)->where([['posts.active', 1], ['posts.status', 3]])->latest()->first())->created_at;
            $dataRelate =  $this->post->mergeLanguage()->whereIn('posts.category_id', $listIdChildren)->where([
                ["posts.id", "<>", $data->id],
            ])->where([['posts.active', 1], ['posts.status', 3]])->latest()->limit($this->limitPostRelate)->get();
            $listIdParent = $this->categoryPost->getALlCategoryParentAndSelf($categoryId);
            // lấy category sidebar theo danh mục
            $listIdActive = $listIdParent;
            $categoryPostSidebar = $this->categoryPost->whereIn(
                'id',
                [$this->idCategoryPostRoot]
            )->get();
            foreach ($listIdParent as $parent) {
                $breadcrumbs[] = $this->categoryPost->mergeLanguage()->find($parent);
            }
            $banner = $this->setting->mergeLanguage()->find(125);
            $tin_tuc = $this->categoryPost->mergeLanguage()->find(21);

            $listIdChildren2 = $this->categoryPost->getALlCategoryChildrenAndSelf(21);

            $dataHotAll =  $this->post->mergeLanguage()->whereIn('posts.category_id', $listIdChildren2)->where([['posts.active', 1], ['posts.hot', 1]])->limit(3)->get();
            //  dd($data->paragraphs);
            return view('frontend.pages.post-detail', [
                'data' => $data,
                'tin_tuc' => $tin_tuc,
                'dataHotAll' => $dataHotAll,
                "dataRelate" => $dataRelate,
                'breadcrumbs' => $breadcrumbs,
                'typeBreadcrumb' => 'category_posts',
                'title' => $data ? $data->name : "",
                'category' => $data->category ?? null,
                'categoryPost' => $categoryPostSidebar,
                'categoryPostActive' => $listIdActive,
                'createLatest' => $createLatest,
                'categoryPostActive' => $listIdActive,
                'banner' => $banner,
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



    // danh sách product theo category
    public function postByCategory($slug)
    {
        // dd(route('product.index',['category'=>$request->category]));
        $breadcrumbs = [];
        $data = [];

        $translation = $this->categoryPostTranslation->where([
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
                        $listIdChildren = $this->categoryPost->getALlCategoryChildrenAndSelf($categoryId);
                        $createLatest = optional($this->post->mergeLanguage()->whereIn('posts.category_id', $listIdChildren)->where([['posts.active', 1]])->latest()->first())->created_at;
                        $data =  $this->post->mergeLanguage()->whereIn('posts.category_id', $listIdChildren)->where([['posts.active', 1]])->latest()->paginate(12);

                        $dataHot =  $this->post->mergeLanguage()->whereIn('posts.category_id', $listIdChildren)->where([['posts.active', 1], ['posts.hot', 1]])->limit(1)->first();

                        $listIdParent = $this->categoryPost->getALlCategoryParentAndSelf($categoryId);
                        // lấy category sidebar theo danh mục
                        foreach ($listIdParent as $parent) {
                            $breadcrumbs[] = $this->categoryPost->mergeLanguage()->find($parent);
                        }
                        $listIdActive = $listIdParent;
                        $categoryPostSidebar = $this->categoryPost->whereIn(
                            'id',
                            [$this->idCategoryPostRoot]
                        )->get();
                        $banner = $this->setting->mergeLanguage()->find(122);

                        $bannerBot = $this->setting->find(125);

                        $tin_tuc = $this->categoryPost->mergeLanguage()->find(21);

                        $listIdChildren2 = $this->categoryPost->getALlCategoryChildrenAndSelf(21);

                        $dataHotAll =  $this->post->mergeLanguage()->whereIn('posts.category_id', $listIdChildren2)->where([['posts.active', 1], ['posts.hot', 1]])->limit(8)->get();

                        if ($categoryId == 22) {
                            return view('frontend.pages.khuyen-mai', [
                                'data' => $data,
                                'unit' => $this->unit,
                                'dataHot' => $dataHot,
                                'breadcrumbs' => $breadcrumbs,
                                'typeBreadcrumb' => 'category_posts',
                                'category' => $category,
                                'categoryPost' => $categoryPostSidebar,
                                'createLatest' => $createLatest,
                                //'typeView' => $typeView,
                                'categoryPostActive' => $listIdActive,
                                'banner' => $banner,
                                'bannerBot' => $bannerBot,

                                'seo' => [
                                    'title' =>  $category->title_seo ?? "",
                                    'keywords' =>  $category->keywords_seo ?? "",
                                    'description' =>  $category->description_seo ?? "",
                                    'image' => $category->avatar_path ?? "",
                                    'abstract' =>  $category->description_seo ?? "",
                                ]
                            ]);
                        } else {
                            return view('frontend.pages.post-by-category', [
                                'data' => $data,
                                'unit' => $this->unit,
                                'tin_tuc' => $tin_tuc,
                                'dataHotAll' => $dataHotAll,
                                'breadcrumbs' => $breadcrumbs,
                                'typeBreadcrumb' => 'category_posts',
                                'category' => $category,
                                'categoryPost' => $categoryPostSidebar,
                                'createLatest' => $createLatest,
                                //'typeView' => $typeView,
                                'categoryPostActive' => $listIdActive,
                                'banner' => $banner,
                                'bannerBot' => $bannerBot,

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
    }

    public function tag($slug)
    {

        // dd(route('product.index',['category'=>$request->category]));
        $breadcrumbs = [];
        $data = [];

        $tag = Tag::where([
            ['name', $slug],
        ])->get();


        foreach ($tag as $keyT => $value) {
            if (Str::lower($value->name) !== Str::lower($slug)) {
                $tag->forget($keyT);
            }
        }
        $tag = $tag->first();


        if ($tag) {
            $data = [];
            $listIdPost = $tag->postTags()->pluck('post_id');

            if ($listIdPost->count() > 0) {
                $data = $this->post
                    ->whereIn('posts.id', $listIdPost)
                    ->where([['posts.active', 1]])
                    ->paginate(20);

                return view('frontend.pages.tag', [
                    'data' => $data,
                    'unit' => $this->unit,
                    'slug' => $slug,
                    //  'breadcrumbs' => $breadcrumbs,
                    // 'typeBreadcrumb' => 'category_posts',
                    //'categoryPost' => $categoryPostSidebar,

                    //'typeView' => $typeView,
                    // 'categoryPostActive' => $listIdActive,
                    'seo' => [
                        'title' =>   $slug,
                        'keywords' => $slug,
                        'description' =>  $slug,
                        'image' => '',
                        'abstract' =>  $slug,
                    ]
                ]);
            } else {
                return view('frontend.pages.tag', [
                    'data' => $data,
                    'unit' => $this->unit,
                    'slug' => $slug,
                    //  'breadcrumbs' => $breadcrumbs,
                    // 'typeBreadcrumb' => 'category_posts',
                    //'categoryPost' => $categoryPostSidebar,

                    //'typeView' => $typeView,
                    // 'categoryPostActive' => $listIdActive,
                    'seo' => [
                        'title' =>   $slug,
                        'keywords' => $slug,
                        'description' =>  $slug,
                        'image' => '',
                        'abstract' =>  $slug,
                    ]
                ]);
            }
        }
    }


    public function viewFile($slug)
    {
        $breadcrumbs = [];
        $data = [];
        $translation = $this->postTranslation->where([
            ["slug", $slug],
        ])->first();

        if ($translation) {
            $data = $translation->post;
            if ($data->file_path) {
                return redirect($data->file_path);
            } else {
                echo "Không có file nào";
            }
        }
    }
    public function downloadFile($slug)
    {
        $breadcrumbs = [];
        $data = [];
        $translation = $this->postTranslation->where([
            ["slug", $slug],
        ])->first();

        if ($translation) {
            $data = $translation->post;
            if ($data->file_path) {
                $path = $data->file_path;
                $path = \Str::after($path, '/storage');
                return Storage::download('public' . $path);
            } else {
                echo "Không có file nào";
            }
        }
    }
}
