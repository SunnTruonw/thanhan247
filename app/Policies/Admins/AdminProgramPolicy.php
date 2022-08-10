<?php

namespace App\Policies\Admins;

use App\Models\Program;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminProgramPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function list(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.program-list'));
    }
    public function add(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.program-add'));
    }
    public function edit(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.program-edit'));
    }
    public function delete(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.program-delete'));
    }
}
