<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryGalaxyTranslation extends Model
{
    protected $table = "category_galaxy_translations";
    // public $fillable =['name'];
    protected $guarded = [];
    public function category()
    {
        return $this->belongsTo(CategoryGalaxy::class, 'category_id', 'id');
    }
}
