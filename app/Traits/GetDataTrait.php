<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Setting;
use App\Models\CategoryPost;
use App\Models\CategoryProduct;
use App\Helper\CartHelper;
use App\Helper\CompareHelper;
use App\Models\Supplier;
use App\Models\Attribute;
use App\Models\Post;
use App\Models\Product;
use App\Models\Galaxy;
use App\Models\CategoryGalaxy;
use  Illuminate\Support\Facades\App;

/**
 *
 */
trait GetDataTrait
{
    /*
     store image upload and return null || array
     @param
     $request type Request, data input
     $fieldName type string, name of field input file
     $folderName type string; name of folder store
     return array
     [
         "file_name","file_path"
     ]
    */
    public function getDataHeaderTrait($setting)
    {
        // laays ngon ngu
        $lang =   App::getLocale();

        //   $cart = new CartHelper();
        //  $totalQuantity =  $cart->getTotalQuantity();
        //   $compare = new CompareHelper();
        //   $totalCompareQuantity =  $compare->getTotalQuantity();

        $header['hotline'] = $setting->mergeLanguage()->find(184);
		$header['hotline1'] = $setting->mergeLanguage()->find(208);
		$header['hotline2'] = $setting->mergeLanguage()->find(207);
        $header['email'] = $setting->mergeLanguage()->find(3);
        $header['address'] = $setting->mergeLanguage()->find(183);
        $header['title'] = $setting->mergeLanguage()->find(89);

        $header['logo'] = $setting->mergeLanguage()->find(13);
        $header['seo_home'] = $setting->mergeLanguage()->find(192);

        $header['socialParent'] = $setting->mergeLanguage()->where('parent_id', 11)->get();
        $header['company'] = $setting->mergeLanguage()->find(231);
        //   $header['totalQuantity'] = $totalQuantity;
        //  $header['totalCompareQuantity'] = $totalCompareQuantity;

        $menu = [];
        $menu_left = [];
		$menu_right1 = [];
        $menu_right = [];
        $menu_left2 = [];
        //  $categoryProduct=new CategoryProduct();

        // $listCategoryProduct=$categoryProduct->where([
        //     'active'=>1
        // ])->whereIn(
        //     'id',[2]
        // )->orderby('order')->pluck('id');
        // foreach ($listCategoryProduct as $id) {
        //     array_push($menu,menuRecusive($categoryProduct,$id));
        // }


        // lấy megamenu
        // $menuM=[];
        // $listCategoryProduct=$categoryProduct->where([
        //     'active'=>1
        // ])->whereIn(
        //     'id',[2]
        // )->orderby('order')->pluck('id');
        // foreach ($listCategoryProduct as $id) {
        //     array_push($menuM,menuRecusive($categoryProduct,$id));
        // }


        $categoryPost = new CategoryPost();
        //$menu_left = $categoryPost->getALlModelCategoryChildren(21);
        //dd($menu);
        //$listCategoryPost = $categoryPost->whereIn(
        //    'id',
        //    [15,18]
        //)->where('active', 1)->orderby('order')->latest()->pluck('id');
        //
        //foreach ($listCategoryPost as $id) {
        //   array_push($menu_left, menuRecusive2($categoryPost, $id));
        //}



        $categoryProduct = new CategoryProduct();
        //$menu_left = $categoryProduct->getALlModelCategoryChildren(7);
        $listCategoryProduct = $categoryProduct->whereIn(
            'id',
            [7,21]
        )->where('active', 1)->orderby('order')->latest()->pluck('id');

        foreach ($listCategoryProduct as $id) {
            array_push($menu_left, menuRecusive2($categoryProduct, $id));
        }


		$categoryPost = new CategoryPost();
        //$menu_left = $categoryPost->getALlModelCategoryChildren(21);
        //dd($menu);
        $listCategoryPost = $categoryPost->whereIn(
            'id',
            [78,79,80,81]
        )->where('active', 1)->orderby('order')->latest()->pluck('id');
        
        foreach ($listCategoryPost as $id) {
           array_push($menu_right, menuRecusive2($categoryPost, $id));
        }
		$listCategoryPost = $categoryPost->whereIn(
            'id',
            [77]
        )->where('active', 1)->orderby('order')->latest()->pluck('id');
        
        foreach ($listCategoryPost as $id) {
           array_push($menu_right1, menuRecusive2($categoryPost, $id));
        }



        $header['about_us'] = $categoryPost->mergeLanguage()->find(77);

        $header['since'] = $categoryProduct->mergeLanguage()->find(21);

        $header['product'] = $categoryProduct->mergeLanguage()->find(7);

        $header['tin_tuc'] = $categoryPost->mergeLanguage()->find(21);

        $header['khuyen-mai'] = $categoryPost->mergeLanguage()->find(22);

        $setting = new Setting();
        // lấy sidebar
        $header['bannerHome'] = $setting->mergeLanguage()->find(18);


        $categoryGalaxyModel = new CategoryGalaxy();
        $header['video'] = $categoryGalaxyModel->mergeLanguage()->find(1);
        $header['hinhanh'] = $categoryGalaxyModel->mergeLanguage()->find(2);

        // dd($menu);
        $header['menu'] =  [
            [
                'nameL' => __('home.home'),
                'slug_full' => makeLink('home'),
                'child' => []
            ],
            // [
            //     'name'=>__('home.gioi_thieu'),
            //     'slug_full'=>makeLinkToLanguage('about-us',null,null,$lang),
            //     'childs'=>[
            //     ]
            // ],

            ...$menu,
            // [
            //     'name'=>__('home.lien_he'),
            //     'slug_full'=>makeLinkToLanguage('contact',null,null,$lang),
            // ],
            // [
            //     'name' => 'Văn bản',
            //     'slug_full' => makeLinkProduct('index'),
            //     'childs' => []
            // ],
            [
                'nameL' => 'Video Clip',
                'slug_full' => makeLinkGalaxy('index'),
                'child' => []
            ]
        ];
		$header['menu_right1'] =  [
            ...$menu_right1,
        ];
        $header['menu_left'] =  [
            ...$menu_left,
        ];

        $header['menu_right'] =  [
            ...$menu_right,
        ];

      //  dd( $header['menu'] );

        return  $header;
    }

    public function getDataFooterTrait($setting)
    {
        $footer = [];
        $footer['dataAddress'] = $setting->find(128);
        //  $footer['linkFooter'] = $setting->find([37]);
        //  $footer['linkFooterBottom'] = $setting->find(97);
        // $footer['registerSale'] = $setting->find(45);
        $footer['logo'] = $setting->mergeLanguage()->find(15);
        $footer['coppy_right'] = $setting->mergeLanguage()->find(204);
		$footer['lien_ket'] = $setting->find(240);
        $footer['socialParent'] = $setting->mergeLanguage()->where('parent_id', 11)->get();
        // $footer['pay'] = $setting->find(52);

        //  $footer['map']=$setting->find(53);
        //  $footer['banner_shipping'] = $setting->find(75);
        //  $footer['banner_giua'] = $setting->find(78);
        //   $footer['logo_banner_shipping'] = $setting->find(77);
        //  $footer['nhan_tu_van'] = $setting->find(76);
        //   $footer['bocongthuong'] = $setting->find(65);
        //   $footer['maqr'] = $setting->find(66);
        $footer['about'] = $setting->mergeLanguage()->find(128);

        $footer['hour_open'] = $setting->mergeLanguage()->find(239);

        $cate_post = new CategoryPost();

        $list_cate = $cate_post->mergeLanguage()->where('category_posts.parent_id','1')->where('category_posts.active','1')->orderby('order')->latest()->get();
        $footer['list_cate'] = $list_cate;

        $footer['doitac'] = $setting->mergeLanguage()->find(249);
		 $footer['khachhang'] = $setting->mergeLanguage()->find(250);

        $footer['trang_chu'] = $setting->mergeLanguage()->find(174);

        $post = new Post();

        $footer['policy1'] = $post->mergeLanguage()->where('active',1)->find(23);
        $footer['policy2'] = $post->mergeLanguage()->where('active',1)->find(24);

        return  $footer;
    }
    public function getDataSidebarTrait($categoryPost = null, $categoryProduct = null)
    {
        $sidebar = [];
        // lấy nhà cung cấp


        $setting = new Setting();
        // lấy sidebar
        $sidebar['bannerTop'] = $setting->mergeLanguage()->find(115);
        $sidebar['bannerBot'] = $setting->mergeLanguage()->find(118);
        $sidebar['banner_bandoc'] = $setting->mergeLanguage()->find(150);
        $sidebar['bannerBottom'] = $setting->mergeLanguage()->find(139);
        $postModel = new Post();
        $postHot = $postModel->mergeLanguage()->where([['posts.active', 1], ['posts.hot', 1], ['posts.status', 3]])->orderby('order')->latest()->limit(3);
        $sidebar['postHot'] = $postHot->get();
        $sidebar['postHotFirst'] = $sidebar['postHot']->first();
        $categoryGalaxyModel=new CategoryGalaxy();
        $listIdCategoryGalaxy=$categoryGalaxyModel->getALlCategoryChildrenAndSelf(1);

        $galaxyModel = new Galaxy();
        $sidebar['galaxy'] = $galaxyModel->mergeLanguage()->whereIn('galaxies.category_id', $listIdCategoryGalaxy)->where('galaxies.active', 1)->where('galaxies.hot',1)->orderby('order')->latest()->limit(10)->get();

        $categoryProduct = new CategoryProduct();
        $data_vanban = $categoryProduct->mergeLanguage()->where('category_products.id', '2')->where('category_products.active', 1)->first();

        $sidebar['data_vanban'] = $data_vanban;

        $data_congtrinh = $categoryProduct->mergeLanguage()->where('category_products.id', '6')->where('category_products.active', 1)->first();

        $sidebar['data_congtrinh'] = $data_congtrinh;

        $certificate = $postModel->mergeLanguage()->where('posts.category_id', '13')->where('posts.active', 1)->where('posts.hot',1)->orderby('order')->latest()->limit(2)->get();
        $sidebar['certificate'] = $certificate;

        $new_certificate = $postModel->mergeLanguage()->where('posts.category_id', '13')->where('posts.active', 1)->latest()->limit(1)->get();
        $sidebar['new_certificate'] = $new_certificate;

        $sidebar['link_partner'] = $setting->mergeLanguage()->find(132);

        return  $sidebar;
    }
}
