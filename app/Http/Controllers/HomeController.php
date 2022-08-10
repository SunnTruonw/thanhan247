<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Post;
use App\Models\Slider;
use App\Models\CategoryPost;
use App\Models\CategoryProduct;
use App\Models\PostTranslation;
use App\Models\ProductTranslation;
use App\Models\CategoryPostTranslation;
use App\Models\Galaxy;
use App\Models\CategoryGalaxy;
use Illuminate\Support\Carbon;
class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $product;
    private $setting;
    private $slider;
    private $post;
    private $categoryPost;
    private $categoryProduct;
    private $postTranslation;
    private $categoryPostTranslation;
    private $productTranslation;
    private $galaxy;
    private $categoryGalaxy;
    private $productSearchLimit  = 6;
    private $postSearchLimit     = 6;

    private $productHotLimit     = 8;
    private $productNewLimit     = 8;
    private $productViewLimit    = 8;
    private $productPayLimit     = 8;
    private $sliderLimit         = 8;
    private $postsHotLimit       = 8;
    private $unit                = 'đ';
    public function __construct(
        Product $product,
        Setting $setting,
        Slider $slider,
        Post $post,
        CategoryPost $categoryPost,
        CategoryProduct $categoryProduct,
        PostTranslation $postTranslation,
        CategoryPostTranslation $categoryPostTranslation,
        ProductTranslation $productTranslation,
        Galaxy $galaxy,
        CategoryGalaxy $categoryGalaxy
    ) {
        /*$this->middleware('auth');*/
        $this->product = $product;
        $this->setting = $setting;
        $this->slider = $slider;
        $this->post = $post;
        $this->categoryPost = $categoryPost;
        $this->categoryProduct = $categoryProduct;
        $this->postTranslation = $postTranslation;
        $this->categoryPostTranslation = $categoryPostTranslation;
        $this->productTranslation = $productTranslation;
        $this->galaxy = $galaxy;
        $this->categoryGalaxy = $categoryGalaxy;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // public function index()
    // {
    //     return view('home');
    // }
    public function index(Request $request)
    {
        // dd(session()->has('cart'));
        //  $cart=[1=>'test 1'];
        //  $request->session()->put('cart',  $cart);
        //   dd($request->session()->get('cart'));

        //  dd($this->categoryPost->setAppends(['slug_full'])->find(15)->slug_full);

        //    dd(menuRecusive($this->categoryPost,13));
        //  dd($this->categoryPost->find(18)->breadcrumb);
        // $dataSettings = $this->setting->all();
        // // sản phẩm nổi bật
        $productsHot = $this->product->where([
        ['active', 1],
        ['hot', 1],
        ])->orderByDesc('created_at')->limit($this->productHotLimit)->get();
        // // sản phẩm mới
        // $productsNew = $this->product->where([
        //     ['active', 1],
        // ])->orderByDesc('created_at')->limit($this->productNewLimit)->get();
        // // sản phẩm xem nhiều
        // $productsView = $this->product->where([
        //     ['active', 1],
        // ])->orderByDesc('view')->limit($this->productViewLimit)->get();
        // // sản phẩm mua nhiều
        // $productsPay = $this->product->where([
        //     ['active', 1],
        // ])->orderByDesc('pay')->limit($this->productPayLimit)->get();
        // // lấy slider
		
        $sliders = $this->slider->where([
            ['active', 1],
        ])->orderByDesc('created_at')->limit($this->sliderLimit)->get();
		// slidersMob
         $slidersM = $this->setting->where([
            ['active', 1],
            ['parent_id', 271],
        ])->orderBy('order')->orderByDesc('created_at')->limit($this->sliderLimit)->get();
        // // bài viết nổi bật
        $postsHot = $this->post->where([
            ['active', 1],
            ['hot', 1],
        ])->orderby('order')->orderByDesc('created_at')->limit($this->postsHotLimit)->get();

        $bannerHome = $this->setting->mergeLanguage()->where('settings.parent_id', '18')->orderby('order')->latest()->get();

		$listCateHot = $this->categoryProduct->where('active',1)->where('category_products.id',21)->orderBy('order')->orderByDesc('created_at')->get();
        $cate = $this->categoryPost->mergeLanguage()->where('category_posts.parent_id',1)->where('category_posts.active',1)->orderby('order')->latest()->get();
        $categoryGalaxy=   $this->categoryGalaxy->mergeLanguage()->find(1);

      //  $postByCategory = $this->post->whereIn('category_id', $cate)->orderByDesc('created_at')->limit(6)->get();
        // dd($postNew);
     //   $supportHome = $this->setting->find(90);
       // $banner2Home = $this->setting->find(93);
		$titleSPBanchay=$this->setting->find(273);

        $service = $this->categoryProduct->mergeLanguage()->where('category_products.id',7)->where('category_products.active',1)->first();
		
        $motaHoGold = $this->post->mergeLanguage()->where('category_id',74)->where('active',1)->orderByDesc('created_at')->get();

        $listIdCatePost = $this->categoryPost->getALlCategoryChildrenAndSelf(79);

        $listCateProduct = $this->categoryProduct->mergeLanguage()->where('parent_id',7)->orderby('order')->get();

        $listWhy = $this->setting->mergeLanguage()->find(263);

        $catePost = $this->categoryPost->mergeLanguage()->find(21);

        $catePostHot = $this->categoryPost->mergeLanguage()->where('category_posts.id',79)->where('category_posts.active',1)->first();
		$dichvupost = $this->setting->mergeLanguage()->find(270);
        return view('frontend.pages.home', [
            'productHot' => $productsHot,
            // 'productNew' => $productsNew,
            // 'productView' => $productsView,
            // 'productPay' => $productsPay,
            // 'postsHot'  => $postsHot,
            // 'dataSettings' => $dataSettings,
            "slider" => $sliders,
			"slidersM" => $slidersM,
            "catePost" => $catePost,
            "listWhy" => $listWhy,
			"dichvupost" => $dichvupost,

           // 'postNew' => $postNew,
            "unit" => $this->unit,
            "listIdCatePost" => $listIdCatePost,
            "listCateProduct" => $listCateProduct,
            "catePostHot" => $catePostHot,
			'listCateHot' => $listCateHot,
            "service" => $service,
            "motaHoGold" => $motaHoGold,
            "bannerHome" => $bannerHome,
           // "supportHome" => $supportHome,
          //  "banner2Home" => $banner2Home,
          'categoryPostHome'=>$cate,
          'categoryGalaxy'=>$categoryGalaxy,
        ]);
    }

    public function aboutUs(Request $request)
    {
      //  dd(checkRouteLanguage2());
        $resultCheckLang = checkRouteLanguage2();
        if ($resultCheckLang) {
            return $resultCheckLang;
        }
        $data = $this->categoryPost->mergeLanguage()->find(75);
        $breadcrumbs = [[
            'id' => $data->id,
            'name' => $data->name,
            'slug' => makeLinkToLanguage('about-us', null, null, \App::getLocale()),
        ]];
        //Về chúng tôi
    
        return view("frontend.pages.about-us", [
            "data" => $data,
            'breadcrumbs' => $breadcrumbs,
			'categoryProductHome'=>$categoryProductHome,
            'typeBreadcrumb' => 'about-us',
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

    public function golfCourse(Request $request)
    {
      //  dd(checkRouteLanguage2());
        $resultCheckLang = checkRouteLanguage2();
        if ($resultCheckLang) {
            return $resultCheckLang;
        }

        $data = $this->categoryPost->mergeLanguage()->find(16);

        $san_gold = $this->categoryPost->mergeLanguage()->find(27);

        $bang_gia = $this->categoryPost->mergeLanguage()->find(30);

        $dat_cho = $this->categoryPost->mergeLanguage()->find(31);

        $story = $this->categoryPost->mergeLanguage()->find(32);

        $breadcrumbs = [[
            'id' => $data->id,
            'name' => $data->name,
            'slug' => makeLinkToLanguage('golf-course', null, null, \App::getLocale()),
        ]];
        //Về chúng tôi
    
        return view("frontend.pages.san-gold", [
            "data" => $data,
            'breadcrumbs' => $breadcrumbs,
            'san_gold' => $san_gold,
            'bang_gia' => $bang_gia,
            'dat_cho' => $dat_cho,
            'story' => $story,
            'typeBreadcrumb' => 'golf-course',
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


    public function featuresGolf(Request $request)
    {
      //  dd(checkRouteLanguage2());
        $resultCheckLang = checkRouteLanguage2();
        if ($resultCheckLang) {
            return $resultCheckLang;
        }
        $data = $this->categoryPost->mergeLanguage()->find(17);

        $trai_nghiem = $this->categoryPost->mergeLanguage()->find(36);

        $breadcrumbs = [[
            'id' => $data->id,
            'name' => $data->name,
            'slug' => makeLinkToLanguage('features-golf', null, null, \App::getLocale()),
        ]];
        //Về chúng tôi
    
        return view("frontend.pages.dac-diem-ho-gold", [
            "data" => $data,
            'breadcrumbs' => $breadcrumbs,
            'trai_nghiem' => $trai_nghiem,
            'typeBreadcrumb' => 'features-golf',
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


    public function practicingField(Request $request)
    {
      //  dd(checkRouteLanguage2());
        $resultCheckLang = checkRouteLanguage2();
        if ($resultCheckLang) {
            return $resultCheckLang;
        }

        $data = $this->categoryPost->mergeLanguage()->find(19);

        $san_gold = $this->categoryPost->mergeLanguage()->find(37);

        $hoc_gold = $this->categoryPost->mergeLanguage()->find(38);

        $bang_gia = $this->categoryPost->mergeLanguage()->find(39);

        $why = $this->categoryPost->mergeLanguage()->find(40);


        $breadcrumbs = [[
            'id' => $data->id,
            'name' => $data->name,
            'slug' => makeLinkToLanguage('practicing-field', null, null, \App::getLocale()),
        ]];
        //Về chúng tôi
    
        return view("frontend.pages.san-tap", [
            "data" => $data,
            'breadcrumbs' => $breadcrumbs,
            'san_gold' => $san_gold,
            'hoc_gold' => $hoc_gold,
            'bang_gia' => $bang_gia,
            'why' => $why,
            'typeBreadcrumb' => 'practicing-field',
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


    public function academy(Request $request)
    {
      //  dd(checkRouteLanguage2());
        $resultCheckLang = checkRouteLanguage2();
        if ($resultCheckLang) {
            return $resultCheckLang;
        }

        $data = $this->categoryPost->mergeLanguage()->find(20);

        $san_gold = $this->categoryPost->mergeLanguage()->find(44);

        $ke_hoach = $this->categoryPost->mergeLanguage()->find(45);

        $the_manh = $this->categoryPost->mergeLanguage()->find(46);


        $breadcrumbs = [[
            'id' => $data->id,
            'name' => $data->name,
            'slug' => makeLinkToLanguage('academy', null, null, \App::getLocale()),
        ]];
        //Về chúng tôi
    
        return view("frontend.pages.hoc-vien", [
            "data" => $data,
            'breadcrumbs' => $breadcrumbs,
            'san_gold' => $san_gold,
            'ke_hoach' => $ke_hoach,
            'the_manh' => $the_manh,
            'typeBreadcrumb' => 'academy',
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


    public function recruitment(Request $request)
    {

        $resultCheckLang = checkRouteLanguage2();
        if ($resultCheckLang) {
            return $resultCheckLang;
        }
        $data = $this->categoryPost->mergeLanguage()->find(14);
        if($data){
            $breadcrumbs = [[
                'id' => $data->id,
                'name' => $data->name,
                'slug' => makeLinkToLanguage('tuyen-dung', null, null, \App::getLocale()),
            ]];


            //Về chúng tôi
           // $tuyenDung = $this->categoryPost->where('id', '4')->orderByDesc('created_at')->first();
            return view("frontend.pages.tuyendung", [
                "data" => $data,
                'breadcrumbs' => $breadcrumbs,
                //  'tuyenDung' => $tuyenDung,
                'typeBreadcrumb' => 'about-us',
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

    public function tuyendungDetail($slug)
    {
        $resultCheckLang = checkRouteLanguage2($slug);
        if ($resultCheckLang) {
            return $resultCheckLang;
        }

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

            $categoryId = $data->category_id;
            $listIdChildren = $this->categoryPost->getALlCategoryChildrenAndSelf($categoryId);
            $dataRelate =  $this->post->whereIn('category_id', $listIdChildren)->where([
                ["id", "<>", $data->id],
            ])->limit(5)->get();
            $listIdParent = $this->categoryPost->getALlCategoryParentAndSelf($categoryId);
            foreach ($listIdParent as $parent) {
                $breadcrumbs[] = $this->categoryPost->select('id', 'name', 'slug')->find($parent);
            }
            //Tin noi bat
            $post_hot =  $this->post->where('hot', 1)->orderByDesc('created_at')->limit(4)->get();

            return view('frontend.pages.tuyendung-detail', [
                'data' => $data,
                'post_hot' => $post_hot,
                "dataRelate" => $dataRelate,
                'breadcrumbs' => $breadcrumbs,
                'typeBreadcrumb' => 'tuyen-dung',
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

    public function bao_gia(Request $request)
    {
        $resultCheckLang = checkRouteLanguage2();
        if ($resultCheckLang) {
            return $resultCheckLang;
        }
        $data = $this->categoryPost->find(40);
        $breadcrumbs = [[
            'id' => $data->id,
            'name' => $data->name,
            'slug' => makeLinkToLanguage('bao-gia', null, null, \App::getLocale()),
        ]];

        $listCategoryHome = $this->categoryProduct->where('parent_id', '76')->where('active', 1)->orderBy('created_at', 'ASC')->limit(4)->get();

        return view("frontend.pages.baogia", [
            "data" => $data,
            "listCategoryHome" => $listCategoryHome,
            'breadcrumbs' => $breadcrumbs,
            'typeBreadcrumb' => 'bao-gia',
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

    public function storeAjax(Request $request)
    {
        //   dd($request->name);
        // dd($request->ajax());
        try {
            DB::beginTransaction();

            $dataContactCreate = [
                'name' => $request->input('name'),
                'phone' => $request->input('phone') ?? "",
                'email' => $request->input('email') ?? "",
                'sex' => $request->input('sex') ?? 1,
                'from' => $request->input('from') ?? "",
                'to' => $request->input('to') ?? "",
                'service' => $request->input('service') ?? "",
                'content' => $request->input('content') ?? null,
            ];
            //  dd($dataContactCreate);
            $contact = $this->contact->create($dataContactCreate);
            //  dd($contact);
            DB::commit();
            return response()->json([
                "code" => 200,
                "html" => 'Gửi thông tin thành công',
                "message" => "success"
            ], 200);
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return response()->json([
                "code" => 500,
                'html' => 'Gửi thông tin không thành công',
                "message" => "fail"
            ], 500);
        }
    }

    public function search(Request $request)
    {
        $dataProduct = $this->product;
        $dataPost = $this->post->mergeLanguage();
        $where = [];
        $req = [];
        // if ($request->has('category_id')) {
        //     $categoryId = $request->category_id;
        //     $listIdChildren = $this->categoryProduct->getALlCategoryChildrenAndSelf($categoryId);
        //     $dataProduct =  $this->product->whereIn('category_id', $listIdChildren);
        // }
        //  dd($dataProduct->get());
        if ($request->input('keyword')) {

            // $dataProduct = $dataProduct->where(function ($query) {
            //     $idProTran = $this->productTranslation->where([
            //         ['name', 'like', '%' . request()->input('keyword') . '%']
            //     ])->pluck('product_id');

            //     $query->whereIn('id', $idProTran)->orWhere([
            //         ['masp', 'like', '%' . request()->input('keyword') . '%']
            //     ]);
            // });
            $dataPost = $dataPost->where(function ($query) {
                $idProTran = $this->postTranslation->where([
                    ['name', 'like', '%' . request()->input('keyword') . '%']
                ])->pluck('post_id');

                $query->whereIn('posts.id', $idProTran);
            });
        }
        // if ($where) {
        //     $dataProduct = $dataProduct->where($where)->orderBy("created_at", "DESC");
        //     $dataPost = $dataPost->where($where)->orderBy("created_at", "DESC");
        // }
      //  $dataProduct = $dataProduct->orderBy("order", "ASC")->orderBy("created_at", "DESC")->paginate($this->productSearchLimit);
        $dataPost = $dataPost->orderBy("order")->latest()->paginate($this->postSearchLimit);
      //  dd($dataPost);
        $breadcrumbs = [[
            'id' => null,
            'name' => __('search.tim_kiem'),
            //'slug' => makeLink('search', null, null, $req),
            'slug' => "",
        ]];
       // dd($dataProduct);
        return view("frontend.pages.search", [
            'breadcrumbs' => $breadcrumbs,
            'typeBreadcrumb' => 'search',
            'dataPost' => $dataPost,
           // 'dataPost' => $dataPost,
            'unit' => $this->unit,
            'seo' => [
                'title' =>  "Kết quả tìm kiếm",
                'keywords' =>  "Kết quả tìm kiếm",
                'description' =>  "Kết quả tìm kiếm",
                'image' =>  "Kết quả tìm kiếm",
                'abstract' =>   "Kết quả tìm kiếm",
            ]
        ]);
    }

    public function search_daily(Request $request)
    {

        $dataAddress = $this->setting->find(28);
        $map = $this->setting->find(33);
        $breadcrumbs = [
            [

                'name' => "Liên hệ",
                'slug' => makeLink('contact'),
            ],
        ];

        // Thông tin mục hệ thống
        $system = $this->setting->where('id', '57')->where('active', 1)->orderByDesc('created_at')->first();

        // Thông tin item mục hệ thống
        $systemChilds = $this->setting->where('parent_id', '57')->where('active', 1)->orderByDesc('created_at')->limit(2)->get();

        $data = $request->all();
        $key = $request->input('keyword');
        if ($key) {
            $listAddress = $this->setting->where('parent_id', '28')->where('name', 'LIKE', '%' . $key . '%')->get();
        }


        return view("frontend.pages.contact", [

            'breadcrumbs' => $breadcrumbs,
            'systemChilds' => $systemChilds,
            'system' => $system,
            'listAddress' => $listAddress,
            'typeBreadcrumb' => 'contact',
            'title' =>  "Thông tin liên hệ",

            'seo' => [
                'title' => "Thông tin liên hệ",
                'keywords' =>  "Thông tin liên hệ",
                'description' =>   "Thông tin liên hệ",
                'image' =>  "",
                'abstract' =>  "Thông tin liên hệ",
            ],

            "dataAddress" => $dataAddress,
            "map" => $map,
        ]);
    }

    public function giaoDienDichVu(){
        return view('frontend.pages.giao-dien-mau.dich-vu');
    }
    public function giaoDienChoiGolf(){
        return view('frontend.pages.giao-dien-mau.choi-golf');
    }
    public function giaoDienTinTuc(){
        return view('frontend.pages.giao-dien-mau.tin-tuc');
    }
    public function giaoDienDacDiemHoGon(){
        return view('frontend.pages.giao-dien-mau.dac-diem-ho-gon');
    }
    public function giaoDienHocGolf(){
        return view('frontend.pages.giao-dien-mau.hoc-golf');
    }
    public function giaoDienHocVien(){
        return view('frontend.pages.giao-dien-mau.hoc-vien');
    }
    public function giaoDienKhuyenMai(){
        return view('frontend.pages.giao-dien-mau.khuyen-mai');
    }
    public function giaoDienLienHe(){
        return view('frontend.pages.giao-dien-mau.lien-he');
    }
    public function giaoDienThuVienAnh(){
        return view('frontend.pages.giao-dien-mau.thu-vien-anh');
    }
    public function giaoDienTienIch(){
        return view('frontend.pages.giao-dien-mau.tien-ich');
    }
}
