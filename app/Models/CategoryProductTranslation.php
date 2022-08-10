<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryProductTranslation extends Model
{
    //
    protected $table = "category_product_translations";
    // public $fillable =['name'];
    protected $guarded = [];
    public function category()
    {
        return $this->belongsTo(CategoryProduct::class, 'category_id', 'id');
    }
}
