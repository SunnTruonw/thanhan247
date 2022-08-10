<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //
    protected $table = "tasks";
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id', 'id');
    }
    public function answers()
    {
        return $this->hasMany(TaskAnswer::class, 'task_id', 'id');
    }
}
