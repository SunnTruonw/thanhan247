<?php

namespace App\Policies\Admins;

use App\Models\CategoryPost;
use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminCategoryPostPolicy
{
    use HandlesAuthorization;

    public function list(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.category-post-list'));
    }
    public function add(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.category-post-add'));
    }
    public function edit(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.category-post-edit'));
    }
    public function delete(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.category-post-delete'));
    }
}
