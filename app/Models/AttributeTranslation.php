<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeTranslation extends Model
{
    //
    protected $table = "attribute_translations";
    // public $fillable =['name'];
    protected $guarded = [];
    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'attribute_id', 'id');
    }
}
