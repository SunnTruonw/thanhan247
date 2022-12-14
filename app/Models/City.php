<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\District;
use App\Models\Commune;
class City extends Model
{
    //
    protected $table="cities";
    protected $guarded = [];
    public function districts(){
      return  $this->hasMany(District::class,'city_id','id');
    }

    const HA_NOI = 1;
}
