<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    //
    protected $table="abouts";

    protected $guarded = [];
     //  protected $appends = ['breadcrumb'];


     public function admin(){
        return $this->belongsTo(Admin::class,'admin_id','id');
     }
     public function adminCreate(){
        return $this->belongsTo(Admin::class,'admin_created_id','id');
     }
}
