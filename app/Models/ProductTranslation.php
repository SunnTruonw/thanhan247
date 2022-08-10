<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductTranslation extends Model
{
    //
    protected $table = "product_translations";
    public $parentId = "parent_id";
    // public $fillable =['name'];
    protected $guarded = [];
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
