<?php

namespace App\Policies\Admins;

use App\Models\CategoryGalaxy;
use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminCategoryGalaxyPolicy
{
    use HandlesAuthorization;

    public function list(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.category-galaxy-list'));
    }
    public function add(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.category-galaxy-add'));
    }
    public function edit(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.category-galaxy-edit'));
    }
    public function delete(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.category-galaxy-delete'));
    }
}
