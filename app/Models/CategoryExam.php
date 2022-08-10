<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Components\Recusive;
use Illuminate\Support\Facades\App;

class CategoryExam extends Model
{
    //
    //use SoftDeletes;
    protected $table = "category_exams";
    public $parentId = "parent_id";
    protected $guarded = [];
    protected $appends = ['slug_full', 'name', 'slug', 'description', 'description_seo', 'keyword_seo', 'title_seo', 'content', 'language'];

    public function getBreadcrumbAttribute()
    {
        $listIdParent = $this->getALlCategoryParent($this->attributes['id']);
        $allData = $this->select('id')->find($listIdParent);
        return $allData;
    }
    public function getSlugFullAttribute()
    {
        return makeLink('category_exams', $this->attributes['id'], $this->getSlugAttribute());
    }

    // tạo thêm thuộc tính name
    public function getNameAttribute()
    {
        return optional($this->translationsLanguage()->first())->name;
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


    // lấy tổng số bài thi trong danh mục
    public  function totalExam()
    {
        $listIdChild = $this->getALlCategoryChildrenAndSelf($this->attributes['id']);
        $modelExam = new \App\Models\Exam();
        return $modelExam->where([
            ['active', 1],
        ])->whereIn('category_id', $listIdChild)->count();
    }
    // lấy tổng lượt thi
    public  function totalExamView()
    {
        $listIdChild = $this->getALlCategoryChildrenAndSelf($this->attributes['id']);
        $modelExam = new \App\Models\Exam();
        return $modelExam->select(\DB::raw('SUM(view) as total'))->where([
            ['active', 1],
        ])->whereIn('category_id', $listIdChild)->first()->total;
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

    // get user was created category_exams
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }
    public function exams()
    {
        return $this->hasMany(Exam::class, 'category_id', 'id');
    }
    public function childs()
    {
        return $this->hasMany(CategoryExam::class, 'parent_id', 'id');
    }
    public function parent()
    {
        return $this->belongsTo(CategoryExam::class, 'parent_id', 'id');
    }

    public function getALlCategoryChildren($id)
    {
        $data = self::select('id', 'parent_id')->get();
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
        return $this->hasMany(CategoryExamTranslation::class, "category_id", "id")->where('language', '=', $language);
    }
    public function translations()
    {
        return $this->hasMany(CategoryExamTranslation::class, "category_id", "id");
    }
}
