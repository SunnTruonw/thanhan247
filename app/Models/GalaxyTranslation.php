<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalaxyTranslation extends Model
{
    protected $table = "galaxy_translations";
    public $parentId = "parent_id";
    protected $guarded = [];
    public function galaxy()
    {
        return $this->belongsTo(Galaxy::class, 'galaxy_id', 'id');
    }
}
