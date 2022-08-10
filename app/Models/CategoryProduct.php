<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
use App\Components\Recusive;
use App\Models\Product;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
class CategoryProduct extends Model
{
    //
    //use SoftDeletes;
    protected $table = "category_products";
    public $parentId = "parent_id";
    protected $guarded = [];
    //  protected $appends = [ 'name','slug','slug_full','description','description_seo','keyword_seo','title_seo','content','language'];
    protected $appends = [ 'slug_full'];
    public function getBreadcrumbAttribute()
    {
        $listIdParent = $this->getALlCategoryParent($this->attributes['id']);
        $allData = $this->mergeLanguage(['name','slug'])->find($listIdParent)->toArray();
        return $allData;
    }

    public function getSlugFullAttribute()
    {
        if(isset($this->slugL)&&$this->slugL){
            return makeLink('category_products', $this->attributes['id'], $this->slugL);
        }elseif($this->slug){
            return makeLink('category_products', $this->attributes['id'], $this->slug);
        }else{
            return makeLink('home');
        }
    }

    // tạo thêm thuộc tính name
    public function getNameAttribute()
    {

        return optional($this->translationsLanguage()->first())->name?optional($this->translationsLanguage()->first())->name:optional($this->translationsLanguage(config('languages.default'))->first())->name;
    }


    // tạo thêm thuộc tính slug
    public function getSlugAttribute()
    {
        return optional($this->translationsLanguage()->first())->slug;
    }
    // tạo thêm thuộc tính description
    public function getDescriptionAttribute()
    {
        return optional($this->translationsLanguage()->first())->description;
    }
    // tạo thêm thuộc tính description_seo
    public function getDescriptionSeoAttribute()
    {
        return optional($this->translationsLanguage()->first())->description_seo;
    }

    // tạo thêm thuộc tính keyword_seo
    public function getKeywordSeoAttribute()
    {
        return optional($this->translationsLanguage()->first())->keyword_seo;
    }


    // tạo thêm thuộc tính title_seo
    public function getTitleSeoAttribute()
    {
        return optional($this->translationsLanguage()->first())->title_seo;
    }

    // tạo thêm thuộc tính content
    public function getContentAttribute()
    {
        return optional($this->translationsLanguage()->first())->content;
    }
    // tạo thêm thuộc tính content
    public function getLanguageAttribute()
    {
        return optional($this->translationsLanguage()->first())->language;
    }

    // lấy số sản phẩm của danh mục
     // tạo thêm thuộc tính name
     public function getCountProductAttribute()
     {
         $pro=new Product();
         $listId=$this->getALlCategoryChildrenAndSelf($this->attributes['id']);
         $count=$pro->whereIn('category_id',$listId)->count();
         return $count;
     }

    public static function getHtmlOption($parentId = "")
    {
        $data = self::all();
        $rec = new Recusive();
        // $prId=$this->parentId;
        return  $rec->categoryRecusive($data, 0, "parent_id", $parentId, "", "");
    }
    public static function getHtmlOptionEdit($parentId = "", $id)
    {
        $data = self::all()->where('id', '<>', $id);
        $rec = new Recusive();
        // $prId=$this->parentId;
      //  dd( $rec->categoryRecusive($data, 0, "parent_id", $parentId, "", "", $id));
        return  $rec->categoryRecusive($data, 0, "parent_id", $parentId, "", "", $id);
    }

    // lấy html option có danh mục cha là $Id
    public static function getHtmlOptionAddWithParent($id)
    {

        $data = self::all();
        $parentId = $id;
        $rec = new Recusive();
        // $prId=$this->parentId;
        return  $rec->categoryRecusive($data, 0, "parent_id", $parentId, "", "");
    }
    // get admin_id was created category_product
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }
    // get product was created category_product
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
    public function childs()
    {
        return $this->hasMany(CategoryProduct::class, 'parent_id', 'id');
    }
    public function parent()
    {
        return $this->belongsTo(CategoryProduct::class, 'parent_id', 'id');
    }

    public function getALlCategoryChildren($id)
    {
        $data = self::all();
        $rec = new Recusive();
        return  $rec->categoryRecusiveAllChild($data, $id);
    }
    public function getALlCategoryChildrenAndSelf($id)
    {
        $data = self::select('id', 'parent_id')->get();
        $rec = new Recusive();
        $arrID = $rec->categoryRecusiveAllChild($data, $id);
        array_unshift($arrID, $id);
        return  $arrID;
    }
    public function getALlCategoryParent($id)
    {
        $data = self::select('id', 'parent_id')->get();
        $rec = new Recusive();
        return  $rec->categoryRecusiveAllParent($data, $id);
    }
    public function getALlCategoryParentAndSelf($id)
    {
        $data = self::select('id', 'parent_id')->get();
        $rec = new Recusive();
        $arrID = $rec->categoryRecusiveAllParent($data, $id);
        array_push($arrID, $id);
        return  $arrID;
    }

    public function translationsLanguage($language = null)
    {
        if ($language == null) {
            $language = App::getLocale();
        }
        return $this->hasMany(CategoryProductTranslation::class, "category_id", "id")->where('language', '=', $language);
    }

    public function translations()
    {
        return $this->hasMany(CategoryProductTranslation::class, "category_id", "id");
    }



    public function childLs($selectLang=[])
    {

        $s='category_product_translations.name as nameL,
        category_product_translations.slug as slugL,
        category_product_translations.description as descriptionL,
        category_product_translations.description_seo as description_seoL,
        category_product_translations.keyword_seo as keyword_seoL,
        category_product_translations.title_seo as title_seoL,
        category_product_translations.content as contentL,
        category_product_translations.language as languageL
        ';
        $s2='category_products.*';
        if(count($selectLang)>0){
            $s=collect($selectLang);
            $stringKey = $s->map(function ($item, $key) {
                return "category_product_translations." . $item." as ".$item."L";
            });
            $s=$stringKey->implode(',');
        }

        return $this->hasMany(CategoryProduct::class, 'parent_id', 'id')
        ->join('category_product_translations', function ($join) {
            $join->on('category_products.id', '=', 'category_product_translations.category_id')
                ->where('category_product_translations.language', '=', App::getLocale());
        })
        ->select($s2,
        DB::raw($s));
    }

    public static function mergeLanguage($selectLang=[]){
        $s='category_product_translations.name as nameL,
        category_product_translations.slug as slugL,
        category_product_translations.description as descriptionL,
        category_product_translations.description_seo as description_seoL,
        category_product_translations.keyword_seo as keyword_seoL,
        category_product_translations.title_seo as title_seoL,
        category_product_translations.content as contentL,
        category_product_translations.language as languageL
        ';
        $s2='category_products.*';
        if(count($selectLang)>0){
            $s=collect($selectLang);
            $stringKey = $s->map(function ($item, $key) {
                return "category_product_translations." . $item." as ".$item."L";
            });
            $s=$stringKey->implode(',');
        }
        // if(count($selectMy)>0){
        //     $s2=collect($selectMy);
        //     $stringKey = $s2->map(function ($item, $key) {
        //         return "category_products." . $item ." as ".$item;
        //     });

        //     $s2=$stringKey->implode(' ');
        // }
        return self::join('category_product_translations', function ($join) {
            $join->on('category_products.id', '=', 'category_product_translations.category_id')
                ->where('category_product_translations.language', '=', App::getLocale());
        })
        ->select($s2,
        DB::raw($s));
    }

    public function getALlModelCategoryChildrenAndSelf($parent,$limit=null,$data=null)
    {
        if(!$data){
            $data = self::mergeLanguage(['name','slug'])->where('category_products.active',1)->orderby('order')->latest()->get();
        }
        $id=$parent->id;
        $rec = new Recusive();


        $slug_full=$parent->slug_full;
        $parent=$parent->toArray();
        $parent['slug_full']=$slug_full;
        $data->map(function($item, $key) {
            $item['slug_full']=makeLinkProduct('category', $item['id'], $item['slugL']);
            return $item;
        });


        $parent['child']=$rec->categoryModelRecusiveAllChild($data, $id,$limit);
       // $arrID = $rec->categoryModelRecusiveAllChild($data, $id,$limit);
       // array_unshift($arrID, $id);
        return  $parent;
    }
    public function getALlModelCategoryChildren($id,$limit=null,$data=null)
    {
        if(!$data){
            $data = self::mergeLanguage(['name','slug'])->where('category_products.active',1)->orderby('order')->latest()->get();
        }

        $data->map(function($item, $key) {
            $item['slug_full']=makeLinkProduct('category', $item['id'], $item['slugL']);
            return $item;
        });

        $rec = new Recusive();
        return  $rec->categoryModelRecusiveAllChild($data, $id,$limit);
    }

    public function getALlModelAdminCategoryChildrenAndSelf($parent,$limit=null,$data=null)
    {
        if(!$data){
            $data = self::mergeLanguage(['name','slug'])->orderby('order')->latest()->get();
        }
        $id=$parent->id;
        $rec = new Recusive();

        $slug_full=$parent->slug_full;
        $parent=$parent->toArray();
        $parent['slug_full']=$slug_full;
        $data->map(function($item, $key) {
            $item['slug_full']=makeLinkProduct('category', $item['id'], $item['slugL']);
            return $item;
        });


        $parent['child']=$rec->categoryModelRecusiveAllChild($data, $id,$limit);
       // $arrID = $rec->categoryModelRecusiveAllChild($data, $id,$limit);
       // array_unshift($arrID, $id);
        return  $parent;
    }
    public function getALlModelAdminCategoryChildren($id,$limit=null,$data=null)
    {
        if(!$data){
            $data = self::mergeLanguage(['name','slug'])->orderby('order')->latest()->get();
        }
        $data->map(function($item, $key) {
            $item['slug_full']=makeLinkProduct('category', $item['id'], $item['slugL']);
            return $item;
        });

        $rec = new Recusive();
        return  $rec->categoryModelRecusiveAllChild($data, $id,$limit);
    }
}
