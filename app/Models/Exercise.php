<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    //
    protected $table = "exercises";
    protected $guarded = [];
    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id', 'id');
    }
    public function answers()
    {
        return $this->hasMany(ExerciseAnswer::class, 'exercise_id', 'id');
    }
    public function admin(){
        return $this->belongsTo(Admin::class,'admin_id','id');
    }
    public function checkAnswer($answer)
    {
        $correct = $this->answers()->where([
            ['correct', true],
        ])->pluck('id');
       //     dd($correct->count()==count($answer)&&$correct->contains(...$answer));
      //  dd($answer);
        if ($correct) {
            if($correct->count()==count($answer)&&$correct->contains(...$answer)){
                return true;
            }
        }

        return false;
    }
}
