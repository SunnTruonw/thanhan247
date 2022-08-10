<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryExamTranslation extends Model
{
    //
    protected $table = "category_exam_translations";
    // public $fillable =['name'];
    protected $guarded = [];
    public function category()
    {
        return $this->belongsTo(CategoryExam::class, 'category_id', 'id');
    }
}
