<?php

namespace App\Policies\Admins;

use App\Models\Post;
use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPostPolicy
{
    use HandlesAuthorization;

    public function list(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.post-list'));
    }
    public function add(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.post-add'));
    }
    public function edit(Admin $user, $id)
    {
        // dd($user->CheckPermissionAccess(config('permissions.access.post-edit-every')));
        $model=new Post();
        $post=$model->find($id);
        $status = $post->status;
        if ($user->CheckPermissionAccess(config('permissions.access.post-edit-every'))) {
            if($status==3){
                if($user->CheckPermissionAccess(config('permissions.access.post-da-duyet'))){
                    return false;
                }else{
                    return true;
                }
            }
            return true;
        } else {

            if ($status == 1||$status == 4) {
                return $user->CheckPermissionAccess(config('permissions.access.post-edit'))&&($user->id==$post->admin_id);
            } else {
                return false;
            }
        }
        return false;
    }

    public function listSelf(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.post-list'))|| $user->CheckPermissionAccess(config('permissions.access.post-list-self'));
    }

    public function hot(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.post-hot'));
    }
    public function active(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.post-active'));
    }
    public function delete(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.post-delete'));
    }
    public function guiDuyet(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.post-send-duyet'));
    }
    public function traBai(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.post-trabai'));
    }
    public function duyet(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.post-duyet'));
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
     * @param  \App\Models\Post  $post
     * @return mixed
     */
    public function view(Admin $user, Post $post)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Admin  $user
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
     * @param  \App\Models\Post  $post
     * @return mixed
     */
    public function update(Admin $user, Post $post)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Post  $post
     * @return mixed
     */
    // public function delete(Admin $user, Post $post)
    // {

    // }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Post  $post
     * @return mixed
     */
    public function restore(Admin $user, Post $post)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Post  $post
     * @return mixed
     */
    public function forceDelete(Admin $user, Post $post)
    {
        //
    }
}
