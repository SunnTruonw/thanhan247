<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuTranslation extends Model
{
    //
    protected $table = "menu_translations";
    public $parentId = "parent_id";
    // public $fillable =['name'];
    protected $guarded = [];
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id', 'id');
    }
}
