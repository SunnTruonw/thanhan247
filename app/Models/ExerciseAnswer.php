<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExerciseAnswer extends Model
{
    //
    protected $table = "exercise_answers";
    protected $guarded = [];
    public function exercise()
    {
        return $this->belongsTo(Exercise::class, 'exercise_id', 'id');
    }
    public function admin(){
        return $this->belongsTo(Admin::class,'admin_id','id');
    }
}
