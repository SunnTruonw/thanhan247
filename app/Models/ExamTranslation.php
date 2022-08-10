<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamTranslation extends Model
{
    //
    protected $table = "exam_translations";
    public $parentId = "parent_id";
    protected $guarded = [];
    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id', 'id');
    }
}
