<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
use App\Components\Recusive;
use Illuminate\Support\Facades\App;

class Attribute extends Model
{
    //
    protected $table = "attributes";
    public $parentId = "parent_id";
    protected $guarded = [];
    protected $appends = ['breadcrumb', 'name', 'value', 'language'];

    public function getBreadcrumbAttribute()
    {
        $listIdParent = $this->getALlCategoryParent($this->attributes['id']);

        $allData = $this->select('id')->find($listIdParent);

        return $allData;
    }
    // tạo thêm thuộc tính name
    public function getNameAttribute()
    {
        //  dd($this->translationsLanguage()->first()->name);
        return optional($this->translationsLanguage()->first())->name;
    }

    // tạo thêm thuộc tính slug
    public function getValueAttribute()
    {
        return optional($this->translationsLanguage()->first())->slug;
    }

    // tạo thêm thuộc tính content
    public function getLanguageAttribute()
    {
        return optional($this->translationsLanguage()->first())->language;
    }

    public function translationsLanguage($language = null)
    {
        if ($language == null) {
            $language = App::getLocale();
        }
        return $this->hasMany(AttributeTranslation::class, "attribute_id", "id")->where('language', '=', $language);
    }
    public function translations()
    {
        return $this->hasMany(AttributeTranslation::class, "attribute_id", "id");
    }

     // lấy sản phẩm
     public function products()
     {
         return $this
             ->belongsToMany(Product::class, ProductAttribute::class, 'attribute_id', 'product_id')
             ->withTimestamps();
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
        return  $rec->categoryRecusive($data, 0, "parent_id", $parentId, "", "");
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
    public function childs()
    {
        return $this->hasMany(Attribute::class, 'parent_id', 'id');
    }
    public function parent()
    {
        return $this->belongsTo(Attribute::class, 'parent_id', 'id');
    }
    public function getALlCategoryChildren($id)
    {
        $data = self::select('id', 'parent_id')->get();
        $rec = new Recusive();
        return  $rec->categoryRecusiveAllChild($data, $id);
    }
    public function getALlCategoryParent($id)
    {
        $data = self::select('id', 'parent_id')->get();
        $rec = new Recusive();
        return  $rec->categoryRecusiveAllParent($data, $id);
    }
}
