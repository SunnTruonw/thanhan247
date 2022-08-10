<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParagraphProgramTranslation extends Model
{
    //
    protected $table = "paragraph_program_translations";
    // public $fillable =['name'];
    protected $guarded = [];
    public function paragraph()
    {
        return $this->belongsTo(ParagraphProgram::class, 'paragraph_id', 'id');
    }
}
