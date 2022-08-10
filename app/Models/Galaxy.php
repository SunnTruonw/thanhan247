<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Components\Recusive;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
class Galaxy extends Model
{
     //use SoftDeletes;
     protected $table = "galaxies";
     public $parentId = "parent_id";
     protected $guarded = [];
     // public $fillable =['name'];

   //  protected $appends = ['slug_full','name','slug','description','description_seo','keyword_seo','title_seo','content','language'];
     public function getSlugFullAttribute()
     {
         if($this->getSlugAttribute()){
             return makeLinkGalaxy('galaxy', $this->attributes['id'], $this->getSlugAttribute());
         }else{
             return makeLink('home');
         }
     }

     // tạo thêm thuộc tính name
     public function getNameAttribute()
     {
         //  dd($this->translationsLanguage()->first()->name);
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

     // get category by relationship 1 - nhieu
     // 1 category_posts có nhiều post
     // 1 post có 1 category_posts
     // use belongsTo để truy xuất ngược từ post lấy data trong table category
     public function category()
     {
         return $this->belongsTo(CategoryGalaxy::class, 'category_id', 'id');
     }

     // get category by relationship nhiều - 1
     public function getAdmin()
     {
         return $this->belongsTo(Admin::class, 'admin_id', 'id');
     }


     public static function getHtmlOption($parentId = "")
     {
         $data = self::all();
         $rec = new Recusive();
         // $prId=$this->parentId;
         return  $rec->categoryRecusive($data, 0, "parent_id", $parentId, "", "");
     }


     public function translationsLanguage($language = null)
     {
         if ($language == null) {
             $language = App::getLocale();
         }
         return $this->hasMany(GalaxyTranslation::class, "galaxy_id", "id")->where('language', '=', $language);
     }
     public function translations()
     {
         return $this->hasMany(GalaxyTranslation::class, "galaxy_id", "id");
     }


    public static function mergeLanguage($selectLang=[]){
        $s='galaxy_translations.name as nameL,
        galaxy_translations.slug as slugL,
        galaxy_translations.description as descriptionL,
        galaxy_translations.description_seo as description_seoL,
        galaxy_translations.keyword_seo as keyword_seoL,
        galaxy_translations.title_seo as title_seoL,
        galaxy_translations.content as contentL,
        galaxy_translations.language as languageL
        ';
        $s2='galaxies.*';
        if(count($selectLang)>0){
            $s=collect($selectLang);
            $stringKey = $s->map(function ($item, $key) {
                return "galaxy_translations." . $item." as ".$item."L";
            });
            $s=$stringKey->implode(',');
        }
        // if(count($selectMy)>0){
        //     $s2=collect($selectMy);
        //     $stringKey = $s2->map(function ($item, $key) {
        //         return "category_programs." . $item ." as ".$item;
        //     });

        //     $s2=$stringKey->implode(' ');
        // }
        return self::join('galaxy_translations', function ($join) {
            $join->on('galaxies.id', '=', 'galaxy_translations.galaxy_id')
                ->where('galaxy_translations.language', '=', App::getLocale());
        })
        ->select($s2,
        DB::raw($s));
    }

}
