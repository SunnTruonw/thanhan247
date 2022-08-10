<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    protected $table="roles";
    protected $guarded = [];

    public function getPermissions(){
        return $this
        ->belongsToMany(Permission::class,PermissionRole::class,'role_id','permission_id','id')
        ->withTimestamps();
    }
}
