<?php

namespace App\Policies\Admins;

use App\Models\CategoryProduct;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminCategoryProductPolicy
{
    use HandlesAuthorization;
    public function list(Admin $admin)
    {
        return $admin->CheckPermissionAccess(config('permissions.access.category-product-list'));
    }
    public function add(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.category-product-add'));
    }
    public function edit(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.category-product-edit'));
    }
    public function delete(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.category-product-delete'));
    }



    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\Admin  $user
     * @return mixed
     */
    public function viewAny(Admin $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\CategoryProduct  $categoryProduct
     * @return mixed
     */
    public function view(Admin $user, CategoryProduct $categoryProduct)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(Admin $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\CategoryProduct  $categoryProduct
     * @return mixed
     */
    public function update(Admin $user, CategoryProduct $categoryProduct)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\CategoryProduct  $categoryProduct
     * @return mixed
     */
    // public function delete(Admin $user, CategoryProduct $categoryProduct)
    // {

    // }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\CategoryProduct  $categoryProduct
     * @return mixed
     */
    public function restore(Admin $user, CategoryProduct $categoryProduct)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\CategoryProduct  $categoryProduct
     * @return mixed
     */
    public function forceDelete(Admin $user, CategoryProduct $categoryProduct)
    {
        //
    }
}
