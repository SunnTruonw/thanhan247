<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramTranslation extends Model
{
    //
    protected $table = "program_translations";
    public $parentId = "parent_id";
    // public $fillable =['name'];
    protected $guarded = [];
    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id', 'id');
    }
}
