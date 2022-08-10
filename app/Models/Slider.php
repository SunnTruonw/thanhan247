<?php

namespace App\Models;
//use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
class Slider extends Model
{
    //
  //  use SoftDeletes;
    protected $table="sliders";
    protected $guarded = [];
    protected $appends = ['name', 'slug',  'description', 'language'];

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
        return $this->hasMany(SliderTranslation::class, "slider_id", "id")->where('language', '=', $language);
    }
    public function translations()
    {
        return $this->hasMany(SliderTranslation::class, "slider_id", "id");
    }



}
