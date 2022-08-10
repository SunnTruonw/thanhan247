<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParagraphPostTranslation extends Model
{
    protected $table = "paragraph_post_translations";
    // public $fillable =['name'];
    protected $guarded = [];
    public function paragraph()
    {
        return $this->belongsTo(ParagraphPost::class, 'paragraph_id', 'id');
    }
}
