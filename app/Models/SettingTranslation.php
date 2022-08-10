<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingTranslation extends Model
{
    //
    protected $table = "setting_translations";
    // public $fillable =['name'];
    protected $guarded = [];
    public function setting()
    {
        return $this->belongsTo(Setting::class, 'setting_id', 'id');
    }
}
