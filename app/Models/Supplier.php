<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
class Supplier extends Model
{
    //
    protected $table = "suppliers";
    protected $guarded = [];
    protected $appends = ['name', 'language'];
     // tạo thêm thuộc tính name
     public function getNameAttribute()
     {
         //  dd($this->translationsLanguage()->first()->name);
         return optional($this->translationsLanguage()->first())->name;
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
        return $this->hasMany(SupplierTranslation::class, "supplier_id", "id")->where('language', '=', $language);
    }
    public function translations()
    {
        return $this->hasMany(SupplierTranslation::class, "supplier_id", "id");
    }
}
