<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\AdminResetPasswordNotification;

class Admin extends Authenticatable
{
    //
    use Notifiable;
    protected $table = "admins";
    protected $guard = 'admin';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'active',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    // get role by relationship nhieu-nhieu by table trung gian role_users
    // table trung gian role_users chứa column role_id và admin_id
    public function getRoles()
    {
        return $this
            ->belongsToMany(Role::class, RoleAdmin::class, 'admin_id', 'role_id')
            ->withTimestamps();
    }
    public function CheckPermissionAccess($key_code)
    {
        $roles = auth()->guard('admin')->user()->getRoles()->get();

        foreach ($roles as $role) {
            $permissions = $role->getPermissions()->pluck('key_code');
          //  dd($permissions);
            if ($permissions->contains($key_code)) {
                return true;
            }
        }
        return false;
    }

    public function posts()
    {
        return $this->hasMany(Post::class, "admin_id", "id");
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPasswordNotification($token));
    }


}
