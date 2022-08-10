<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    // use SoftDeletes;
    protected $table = "comments";
    // public $fillable =['name'];
    protected $guarded = [];

    public function childs()
    {
        return $this->hasMany(Comment::class, 'parent_id', 'id');
    }
}
