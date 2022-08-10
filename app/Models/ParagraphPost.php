<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Components\Recusive;
use Illuminate\Support\Facades\App;
class ParagraphPost extends Model
{
    //

    protected $table = "paragraph_posts";
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
        return optional($this->translationsLanguage()->first())->value;
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
        return $this->hasMany(ParagraphPostTranslation::class, "paragraph_id", "id")->where('language', '=', $language);
    }

    public function translations()
    {
        return $this->hasMany(ParagraphPostTranslation::class, "paragraph_id", "id");
    }

    public static function getHtmlOption($data, $parentId = "")
    {
        //  $data = $itemInstance->paragraphs;
        $rec = new Recusive();
        // $prId=$this->parentId;
        return  $rec->categoryRecusive($data, 0, "parent_id", $parentId, "", "");
    }
    public static function getHtmlOptionEdit($data, $parentId = "", $id)
    {
        // $data = self::all()->where('id', '<>', $id);
        $rec = new Recusive();
        // $prId=$this->parentId;
        return  $rec->categoryRecusive($data, 0, "parent_id", $parentId, "", "", $id);
    }
    // lấy html option có danh mục cha là $Id
    public static function getHtmlOptionAddWithParent($data, $id)
    {
        //  $data = $itemInstance->paragraphs;
        $parentId = $id;
        $rec = new Recusive();
        // $prId=$this->parentId;
        return  $rec->categoryRecusive($data, 0, "parent_id", $parentId, "", "");
    }
    public function childs()
    {
        return $this->hasMany(ParagraphPost::class, 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(ParagraphPost::class, 'parent_id', 'id');
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

    // lấy program

    public function post()
    {
        return $this
            ->belongsTo(Post::class,  'post_id', 'id');
    }
}
