<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParagraphCategoryPostTranslation extends Model
{
    //
    protected $table = "paragraph_category_post_translations";
    // public $fillable =['name'];
    protected $guarded = [];
    public function paragraph()
    {
        return $this->belongsTo(ParagraphCategoryPost::class, 'paragraph_id', 'id');
    }
}
