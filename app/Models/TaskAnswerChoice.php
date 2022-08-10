<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskAnswerChoice extends Model
{
    //
    protected $table = "task_answer_choices";
    protected $guarded = [];
    public function taskAnswer()
    {
        return $this->belongsTo(TaskAnswer::class, 'task_answer_id', 'id');
    }
    public function answer()
    {
        return $this->belongsTo(QuestionAnswer::class, 'answer_id', 'id');
    }
}
