<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Components\Recusive;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
class Setting extends Model
{
    //
    protected $table = "settings";
    protected $guarded = [];
    public $parentId = "parent_id";

   // protected $appends = ['breadcrumb','name', 'slug', 'value', 'description', 'language'];
   public function getBreadcrumbAttribute()
   {
       $listIdParent = $this->getALlCategoryParent($this->attributes['id']);
       $allData = $this->mergeLanguage(['name','slug'])->find($listIdParent)->toArray();
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

      // tạo thêm thuộc tính ảnh
      public function getImagePathAttribute()
      {
          return optional($this->translationsLanguage()->first())->image_path;
      }
      // tạo thêm thuộc tính ảnh
      public function getFileAttribute()
      {
          return optional($this->translationsLanguage()->first())->file;
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
        return $this->hasMany(SettingTranslation::class, "setting_id", "id")->where('language', '=', $language);
    }
    public function translations()
    {
        return $this->hasMany(SettingTranslation::class, "setting_id", "id");
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
        return $this->hasMany(Setting::class, 'parent_id', 'id');
    }
    public function parent()
    {
        return $this->belongsTo(Setting::class, 'parent_id', 'id');
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



    public function childLs($selectLang=[])
    {
        $s='setting_translations.name as nameL,
        setting_translations.slug as slugL,
        setting_translations.value as valueL,
        setting_translations.description as descriptionL,
        setting_translations.image_path as image_pathL,
        setting_translations.file as fileL,
        setting_translations.language as languageL
        ';
        $s2='settings.*';
        if(count($selectLang)>0){
            $s=collect($selectLang);
            $stringKey = $s->map(function ($item, $key) {
                return "setting_translations." . $item." as ".$item."L";
            });
            $s=$stringKey->implode(',');
        }

        return $this->hasMany(Setting::class, 'parent_id', 'id')
            ->join('setting_translations', function ($join) {
                $join->on('settings.id', '=', 'setting_translations.setting_id')
                    ->where('setting_translations.language', '=', App::getLocale());
            })
            ->select(
                $s2,
                DB::raw($s)
            );
    }
    public static function mergeLanguage($selectLang=[]){
        $s='setting_translations.name as nameL,
        setting_translations.slug as slugL,
        setting_translations.value as valueL,
        setting_translations.description as descriptionL,
        setting_translations.image_path as image_pathL,
        setting_translations.file as fileL,
        setting_translations.language as languageL
        ';
        $s2='settings.*';
        if(count($selectLang)>0){
            $s=collect($selectLang);
            $stringKey = $s->map(function ($item, $key) {
                return "setting_translations." . $item." as ".$item."L";
            });
            $s=$stringKey->implode(',');
        }
        // if(count($selectMy)>0){
        //     $s2=collect($selectMy);
        //     $stringKey = $s2->map(function ($item, $key) {
        //         return "category_posts." . $item ." as ".$item;
        //     });
        //     $s2=$stringKey->implode(' ');
        // }
        return self::join('setting_translations', function ($join) {
            $join->on('settings.id', '=', 'setting_translations.setting_id')
                ->where('setting_translations.language', '=', App::getLocale());
        })
        ->select($s2,
        DB::raw($s));
    }


    public function getALlModelCategoryChildrenAndSelf($parent,$limit=null,$data=null)
    {
        $id=$parent->id;
        if(!$data){
            $data = self::mergeLanguage(['name','slug'])->where('settings.active',1)->orderby('order')->latest()->get();
        }

        $rec = new Recusive();
        $parent=$parent->toArray();
        $parent['child']=$rec->categoryModelRecusiveAllChild($data, $id,$limit);
       // $arrID = $rec->categoryModelRecusiveAllChild($data, $id,$limit);
       // array_unshift($arrID, $id);
        return  $parent;
    }
    public function getALlModelCategoryChildren($id,$limit=null,$data=null)
    {
        if(!$data){
            $data = self::mergeLanguage(['name','slug'])->where('settings.active',1)->orderby('order')->latest()->get();
        }

        $rec = new Recusive();
        return  $rec->categoryModelRecusiveAllChild($data, $id,$limit);
    }

    public function getALlModelAdminCategoryChildrenAndSelf($parent,$limit=null,$data=null)
    {
        $id=$parent->id;
        if(!$data){
            $data = self::mergeLanguage(['name','slug'])->orderby('order')->latest()->get();
        }

        $rec = new Recusive();
        $parent=$parent->toArray();
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
        $rec = new Recusive();
        return  $rec->categoryModelRecusiveAllChild($data, $id,$limit);
    }

}
