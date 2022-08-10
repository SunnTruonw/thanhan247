<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryPostTranslation extends Model
{
    //
    protected $table = "category_post_translations";
    // public $fillable =['name'];
    protected $guarded = [];
    public function category()
    {
        return $this->belongsTo(CategoryPost::class, 'category_id', 'id');
    }
}
