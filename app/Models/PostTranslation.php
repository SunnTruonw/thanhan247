<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostTranslation extends Model
{
    //
    protected $table = "post_translations";
    public $parentId = "parent_id";
    // public $fillable =['name'];
    protected $guarded = [];
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }
}
