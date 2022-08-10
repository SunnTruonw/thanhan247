<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryProgramTranslation extends Model
{
    //
    protected $table = "category_program_translations";
    // public $fillable =['name'];
    protected $guarded = [];
    public function category()
    {
        return $this->belongsTo(CategoryProgram::class, 'category_id', 'id');
    }
}
