<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskAnswer extends Model
{
    //
    protected $table = "task_answers";
    protected $guarded = [];
    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id', 'id');
    }
    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id', 'id');
    }
    public function choices()
    {
        return $this->hasMany(TaskAnswerChoice::class, 'task_answer_id', 'id');
    }
    public function checkAnswer($answer)
    {
        $correct = $this->question->answers()->where([
            ['correct', true],
        ])->pluck('id');
       // dd($answer);
        if ($correct) {
            if($correct->count()==count($answer)&&$correct->contains(...$answer)){
                return true;
            }
        }
        return false;
    }
    public function checkAnswerShow()
    {
        # code...
        $choice=$this->choices()->get()->pluck('answer_id');
        return $this->checkAnswer($choice);
    }
}
