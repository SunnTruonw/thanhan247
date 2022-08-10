<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionAnswerTranslation extends Model
{
    //
    protected $table = "question_answer_translations";
    // public $fillable =['name'];
    protected $guarded = [];
    public function answer()
    {
        return $this->belongsTo(QuestionAnswer::class, 'answer_id', 'id');
    }
}
