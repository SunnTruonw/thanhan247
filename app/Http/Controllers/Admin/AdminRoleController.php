<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Admin;
use App\Models\RoleAdmin;
use App\Models\Permission;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Traits\DeleteRecordTrait;
use App\Http\Requests\Admin\Role\ValidateAddRole;
use App\Http\Requests\Admin\Role\ValidateEditRole;
class AdminRoleController extends Controller
{
    //
    use DeleteRecordTrait;
    private $admin;
    private $role;
    private $roleAdmin;
    private $permission;
    public function __construct(Admin $admin,Role $role, RoleAdmin $roleAdmin,Permission $permission){
        $this->admin=$admin;
        $this->role=$role;
        $this->roleAdmin=$roleAdmin;
        $this->permission=$permission;
    }
    public function index(){
        $data = $this->role->orderBy("created_at", "desc")->paginate(20);

        return view(
            "admin.pages.role.list",
            [
                'data' => $data
            ]
        );
    }
    public function create(Request $request = null)
    {
        $dataRoles=$this->role->all();
        $dataPermissions=$this->permission->where('parent_id',0)->get();
        return view(
            "admin.pages.role.add",
            [
                'request' => $request,
                'dataRoles'=>$dataRoles,
                'dataPermissions'=>$dataPermissions,
            ]
        );
    }


    public function store(ValidateAddRole $request)
    {
        try {
            DB::beginTransaction();
            $dataRoleCreate = [
                "name" => $request->input('name'),
                "description" => $request->input('description'),
            ];
            // insert database in role table
            $role = $this->role->create($dataRoleCreate);
            // insert database to permission_roles table
            if ($request->has("permission_id")) {
                $permission_ids=$request->permission_id;
                    $role->getPermissions()->attach($permission_ids);
            }
            DB::commit();
            return redirect()->route('admin.role.create')->with("alert", "add complate");
         } catch (\Exception $exception) {
             //throw $th;
             DB::rollBack();
             Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
             return redirect()->route('admin.user.create');
         }
    }
    public function edit($id)
    {
        $data = $this->role->find($id);
        $dataPermissions = $this->permission->where('parent_id',0)->get();
        $dataPermissionsOfRole=$data->getPermissions();
        return view("admin.pages.role.edit", [
            'data' => $data,
            'dataPermissions' => $dataPermissions,
            'dataPermissionsOfRole'=>$dataPermissionsOfRole,
        ]);
    }

    public function update(ValidateEditRole $request, $id)
    {

        try {
            DB::beginTransaction();
            $dataRoleUpdate = [
                "name" => $request->input('name'),
                "description" => $request->input('description'),
            ];

            // update database in role table
            $this->role->find($id)->update($dataRoleUpdate);
            $role = $this->role->find($id);

            // insert database to permission_roles table
            if ($request->has("permission_id")) {
                $permission_ids=$request->permission_id;
                // Các syncphương pháp chấp nhận một loạt các ID để ra trên bảng trung gian. Bất kỳ ID nào không nằm trong mảng đã cho sẽ bị xóa khỏi bảng trung gian.
                $role->getPermissions()->sync($permission_ids);
            }
            DB::commit();
            return redirect()->route('admin.role.index')->with("alert", "add complate");
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.role.index');
        }
    }

    public function destroy($id)
    {
        return $this->deleteTrait($this->role, $id);
    }
}
