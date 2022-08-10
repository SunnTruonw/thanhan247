<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\CategoryPost;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
class ContactController extends Controller
{
    //
    private $setting;
    private $categoryPost;
    private $contact;
    public function __construct(Setting $setting, Contact $contact, CategoryPost $categoryPost)
    {
        /*$this->middleware('auth');*/
        $this->setting=$setting;
        $this->contact=$contact;
        $this->categoryPost = $categoryPost;
    }
    public function index(){
        $resultCheckLang=checkRouteLanguage2();
        if($resultCheckLang){
            return $resultCheckLang;
        }

		$about2=$this->setting->find(128);
        $dataAddress=$this->setting->find(151);
        $map=$this->setting->find(230);
        $breadcrumbs= [
            [
                'name'=> __('home.lien_he'),
                'slug'=>makeLinkToLanguage('contact',null,null,\App::getLocale()),
            ],
        ];

        


        return view("frontend.pages.contact",[

            'breadcrumbs' => $breadcrumbs,
            'typeBreadcrumb' => 'contact',
            'title' =>  "Thông tin liên hệ",

            'seo' => [
                'title' => __('contact.thong_tin_lien_he'),
                'keywords' =>  __('contact.thong_tin_lien_he'),
                'description' => __('contact.thong_tin_lien_he'),
                'image' =>  asset('/images/logo.jpg'),
                'abstract' =>  __('contact.thong_tin_lien_he'),
            ],

            "about2"=>$about2,
			"dataAddress"=>$dataAddress,
            "map"=>$map,
        ]);
    }

    public function feed_back(){
        $resultCheckLang=checkRouteLanguage2();
        if($resultCheckLang){
            return $resultCheckLang;
        }


        $dataAddress=$this->setting->find(151);
        $map=$this->setting->find(33);
        $list_cate = $this->categoryPost->where('parent_id','1')->where('active','1')->orderby('order')->latest()->get();
        $breadcrumbs= [
            [
                'name'=> __('home.lien_he'),
                'slug'=>makeLinkToLanguage('contact',null,null,\App::getLocale()),
            ],
        ];



        return view("frontend.pages.contact1",[

            'breadcrumbs' => $breadcrumbs,
            'typeBreadcrumb' => 'contact',
            'title' =>  "Thông tin liên hệ",

            'seo' => [
                'title' => __('contact.thong_tin_lien_he'),
                'keywords' =>  __('contact.thong_tin_lien_he'),
                'description' => __('contact.thong_tin_lien_he'),
                'image' =>  asset('/images/logo.jpg'),
                'abstract' =>  __('contact.thong_tin_lien_he'),
            ],
            "list_cate"=>$list_cate,
            "dataAddress"=>$dataAddress,
            "map"=>$map,
        ]);
    }

    public function feed_back2(){
        $resultCheckLang=checkRouteLanguage2();
        if($resultCheckLang){
            return $resultCheckLang;
        }


        $dataAddress=$this->setting->find(151);
        $map=$this->setting->find(33);
        $breadcrumbs= [
            [
                'name'=> __('home.lien_he'),
                'slug'=>makeLinkToLanguage('contact',null,null,\App::getLocale()),
            ],
        ];



        return view("frontend.pages.contact2",[

            'breadcrumbs' => $breadcrumbs,
            'typeBreadcrumb' => 'contact',
            'title' =>  "Thông tin liên hệ",

            'seo' => [
                'title' => __('contact.thong_tin_lien_he'),
                'keywords' =>  __('contact.thong_tin_lien_he'),
                'description' => __('contact.thong_tin_lien_he'),
                'image' =>  asset('/images/logo.jpg'),
                'abstract' =>  __('contact.thong_tin_lien_he'),
            ],

            "dataAddress"=>$dataAddress,
            "map"=>$map,
        ]);
    }


    public function storeAjax(Request $request){
     //   dd($request->name);
    // dd($request->ajax());
         /*try {*/
             DB::beginTransaction();

            $dataContactCreate = [
                'name' => $request->input('name')??"",
                'phone' => $request->input('phone')??"",
                'email' => $request->input('email')??"",
                'active' => $request->input('active')??1,
                'status' => 1,
                'city_id' => $request->input('city_id')??null,
                'district_id' => $request->input('district_id')??null,
                'commune_id' => $request->input('commune_id')??null,
                'address_detail' => $request->input('address_detail')??null,
                'content'=> $request->input('content')??null,
                'admin_id' => 0,
                'user_id' => Auth::check() ? Auth::user()->id : 0,
            ];

            $contact = $this->contact->create($dataContactCreate);
          //  dd($contact);
            DB::commit();
            return response()->json([
            "code" => 200,
            "html" => __('contact.gui_thong_tin_thanh_cong'),
            "message" => "success"
            ], 200);

         /*} catch (\Exception $exception) {*/
             //throw $th;
             DB::rollBack();
             Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
             return response()->json([
                "code" => 500,
                'html'=>__('contact.gui_thong_tin_k_thanh_cong'),
                "message" => "fail"
            ], 500);

         /*}*/
    }
}
