<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CategoryProduct;
use App\Models\CategoryPost;
use App\Models\Setting;
use App\Models\Attribute;
use App\Models\ProductAttribute;
use App\Models\ProductTranslation;
use App\Models\CategoryProductTranslation;
use App\Models\Point;

class ProductController extends Controller
{
    //

    private $product;
    private $header;
    private $unit = 'đ';
    private $categoryProduct;
    private $categoryPost;
    private $productTranslation;
    private $categoryProductTranslation;
    private $attribute;
    private $productAttribute;
    private $point;
    private $limitProduct = 12;
    private $limitProductRelate = 8;
    private $idCategoryProductRoot = 2;
    private $breadcrumbFirst = [
        // 'name'=>'Sản phẩm',
        //  'slug'=>'san-pham',
    ];
    public function __construct(
        Product $product,
        CategoryProduct $categoryProduct,
        CategoryPost $categoryPost,
        Setting $setting,
        ProductTranslation $productTranslation,
        CategoryProductTranslation $categoryProductTranslation,
        Attribute $attribute,
        ProductAttribute $productAttribute,
        Point $point
    ) {
        $this->product = $product;
        $this->categoryProduct = $categoryProduct;
        $this->categoryPost = $categoryPost;
        $this->setting = $setting;
        $this->productTranslation = $productTranslation;
        $this->categoryProductTranslation = $categoryProductTranslation;
        $this->attribute = $attribute;
        $this->productAttribute = $productAttribute;
        $this->point = $point;
    }
    // danh sách toàn bộ product
    public function index(Request $request)
    {
        $breadcrumbs = [];
        $data = [];
        // get category
        $category = $this->categoryProduct->where([
            ['id', $this->idCategoryProductRoot],
        ])->first();
        if ($category) {
            if ($category->count()) {
                $categoryId = $category->id;
                $listIdChildren = $this->categoryProduct->getALlCategoryChildrenAndSelf($categoryId);

                $data =  $this->product->whereIn('category_id', $listIdChildren)->latest()->paginate($this->limitProduct);
                $breadcrumbs[] = $this->categoryProduct->select('id')->find($this->idCategoryProductRoot);
                //  dd($category);


                $dataView = [
                    'data' => $data,
                    'unit' => $this->unit,
                    'breadcrumbs' => $breadcrumbs,
                    'typeBreadcrumb' => 'product_all',
                    'category' => $category,
                    'seo' => [
                        'title' =>  $category->title_seo ?? "",
                        'keywords' =>  $category->keywords_seo ?? "",
                        'description' =>  $category->description_seo ?? "",
                        'image' => $category->avatar_path ?? "",
                        'abstract' =>  $category->description_seo ?? "",
                    ]
                ];
                if (session()->has('dowload')) {
                    $url = session()->get('dowload');
                    session()->forget('dowload');
                    $dataView['dowload'] = $url;
                }

                return view('frontend.pages.product', $dataView);
            }
        }
    }
    public function detail($slug, Request $request)
    {
        //   $data= $this->categoryProduct->setAppends(['breadcrumb'])->where('parent_id',0)->orderBy("created_at", "desc")->paginate(15);
        $breadcrumbs = [];
        $data = [];
        $translation = $this->productTranslation->where([
            ["slug", $slug],
        ])->first();
        if ($translation) {
            $data = $translation->product;
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
            $listIdChildren = $this->categoryProduct->getALlCategoryChildrenAndSelf($categoryId);

            $dataRelate =  $this->product->whereIn('category_id', $listIdChildren)->where([
                ["id", "<>", $data->id],
            ])->limit($this->limitProductRelate)->get();
            $listIdParent = $this->categoryProduct->getALlCategoryParentAndSelf($categoryId);

            foreach ($listIdParent as $parent) {
                $breadcrumbs[] = $this->categoryProduct->mergeLanguage()->find($parent);
            }

            // Lấy danh sản các tất cả sản phẩm cùng danh mục sản phẩm được chọn
            $categoryAll = $this->product->where('category_id', $categoryId)->get();

            $giaohang = $this->setting->find(130);
            $dataView = [
                'data' => $data,
                'categoryAll' => $categoryAll,
                'unit' => $this->unit,
                "dataRelate" => $dataRelate,
                'breadcrumbs' => $breadcrumbs,
                'typeBreadcrumb' => 'category_products',
                'title' => $data ? $data->name : "",
                'category' => $data->category ?? null,
                'giaohang' => $giaohang,
                'seo' => [
                    'title' =>  $data->title_seo ?? "",
                    'keywords' =>  $data->keywords_seo ?? "",
                    'description' =>  $data->description_seo ?? "",
                    'image' => $data->avatar_path ?? "",
                    'abstract' =>  $data->description_seo ?? "",
                ]
            ];
            if (session()->has('dowload')) {
                $url = session()->get('dowload');
                session()->forget('dowload');
                $dataView['dowload'] = $url;
            }
            return view('frontend.pages.product-detail', $dataView);
        }
    }

    // danh sách product theo category
    public function productByCategory($slug, Request $request)
    {
        //
        // dd(route('product.index',['category'=>$request->category]));
        $slider = $this->setting->find(101);
        $breadcrumbs = [];
        // get category
        $translation = $this->categoryProductTranslation->where([
            ['slug', $slug],
        ])->first();
        if ($translation) {
            if ($translation->count()) {

                if ($request->ajax()) {
                    //  dd($request->all());
                    $category = $translation->category;
                    $categoryId = $category->id;
                    $listIdChildren = $this->categoryProduct->getALlCategoryChildrenAndSelf($categoryId);
                    $data =  $this->product;
                    if ($request->has('supplier_id') && $request->input('supplier_id')) {
                        $data = $data->whereIn('supplier_id', $request->input('supplier_id'));
                        // dd($data->get());
                    }
                    if ($request->has('attribute_id') && $request->input('attribute_id')) {
                        $productAttr =  $this->productAttribute;
                        foreach ($request->input('attribute_id') as $key => $value) {
                            // dd($request->input('attribute_id')[$key]);
                            $listIdPro = $productAttr->whereIn('attribute_id', $request->input('attribute_id')[$key])->pluck('product_id');

                            // dd($productAttr->get());
                            $data = $data->whereIn('id', $listIdPro);
                        }
                        // dd($data);
                        // dd($listIdPro);
                        // dd($data->get());
                    }
                    // dd($data->whereIn('category_id', $listIdChildren)->get());
                    if ($request->has('orderby') && $request->input('orderby')) {
                        if ($request->input('orderby') == 1) {
                            $data =  $data->whereIn('category_id', $listIdChildren)->orderby('price')->paginate($this->limitProduct);
                        } else {
                            $data =  $data->whereIn('category_id', $listIdChildren)->orderByDesc('price')->paginate($this->limitProduct);
                        }
                    } else {
                        $data =  $data->whereIn('category_id', $listIdChildren)->orderby('price')->paginate($this->limitProduct);
                    }

                    // dd($data);
                    return response()->json([
                        "code" => 200,
                        "html" => view('frontend.components.load-product-search', ['data' => $data, 'unit' => $this->unit])->render(),
                        "message" => "success"
                    ], 200);
                }

                $category = $translation->category;
                if (checkRouteLanguage($slug, $category)) {
                    return checkRouteLanguage($slug, $category);
                }
                $categoryId = $category->id;
                $listIdChildren = $this->categoryProduct->getALlCategoryChildrenAndSelf($categoryId);

                $data =  $this->product->whereIn('category_id', $listIdChildren)->latest()->paginate($this->limitProduct);
                $listIdParent = $this->categoryProduct->getALlCategoryParentAndSelf($categoryId);
                foreach ($listIdParent as $parent) {
                    $breadcrumbs[] = $this->categoryProduct->mergeLanguage()->find($parent);
                }

                $list = $this->categoryProduct->getALlCategoryChildrenAndSelf($categoryId);
                $listate = $this->categoryProduct->mergeLanguage()->find(7);

                $banner_sidebar = $this->setting->mergeLanguage()->find(232);

                $dataView = [
                    'data' => $data,
                    'listate' => $listate,
                    'banner_sidebar' => $banner_sidebar,
                    'unit' => $this->unit,
                    'breadcrumbs' => $breadcrumbs,
                    'typeBreadcrumb' => 'category_products',
                    'category' => $category,
                    'slider' => $slider,
                    'seo' => [
                        'title' =>  $category->title_seo ?? "",
                        'keywords' =>  $category->keywords_seo ?? "",
                        'description' =>  $category->description_seo ?? "",
                        'image' => $category->avatar_path ?? "",
                        'abstract' =>  $category->description_seo ?? "",
                    ]
                ];

                
                return view('frontend.pages.product-by-category',$dataView);  
                
            }
        }
    }

    public function download($slug)
    {

        if (!\Auth::check()) {
            session()->put('urlBack', url()->previous());
            session()->put('dowload', url()->current());
            return redirect()->route('login');
        }
        $breadcrumbs = [];
        $data = [];
        $translation = $this->productTranslation->where([
            ["slug", $slug],
        ])->first();

        if ($translation) {
            $data = $translation->product;
            if ($data->file) {
                $point = $data->price;
                // dd($point);
                $user = \Auth::guard('web')->user();
                $sumPointCurrent =  $this->point->sumPointCurrent($user->id);
                if ($sumPointCurrent >= $point) {
                    $point = $user->points()->create([
                        'type' => 2,
                        'origin_id' => $data->id,
                        'point' => -$point,
                    ]);
                    $path = $data->file;
                    $path = \Str::after($path, '/storage');
                    //   $dowCheck=\Storage::download('public' . $path);
                    $fileDownUpdate = $data->file_down;
                    if ($data->view) {
                        $fileDownUpdate++;
                    } else {
                        $fileDownUpdate = 1;
                    }
                    $data->update([
                        'file_down' => $fileDownUpdate,
                    ]);
                    return \Storage::download('public' . $path);
                } else {

                    return  redirect(makeLinkToLanguage('about-us', null, null, \App::getLocale()))->with('errorDownload', 'Số điểm hiện có của bạn là ' . $sumPointCurrent . ' không đủ để mua văn bản (' . $point . ') vui lòng nạp thêm điểm để download văn bản này');
                }
            } else {
                echo "Không có file nào";
            }
        }
    }
}
