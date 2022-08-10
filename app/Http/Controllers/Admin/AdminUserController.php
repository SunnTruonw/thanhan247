<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Role;
use App\Models\RoleAdmin;
use App\Traits\DeleteRecordTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\Admin\Admin\ValidateAddAdminUser;
use App\Http\Requests\Admin\Admin\ValidateEditAdminUser;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    //
    use DeleteRecordTrait;
    private $admin;
    private $role;
    private $roleAdmin;
    public function __construct(Admin $admin,Role $role, RoleAdmin $roleAdmin){
        $this->admin=$admin;
        $this->role=$role;
        $this->roleAdmin=$roleAdmin;
    }
    public function index(){
        $data = $this->admin->where('id','<>',7)->orderBy("created_at", "desc")->paginate(15);
        return view(
            "admin.pages.user.list",
            [
                'data' => $data
            ]
        );
    }
    public function create(Request $request = null)
    {
        $dataRoles=$this->role->all();
        return view(
            "admin.pages.user.add",
            [
                'request' => $request,
                'dataRoles'=>$dataRoles,
            ]
        );
    }
    public function store(ValidateAddAdminUser $request)
    {
        try {
            DB::beginTransaction();
            $dataAdminUserCreate = [
                "name" => $request->input('name'),
                "email" => $request->input('email'),
                "password" =>Hash::make($request->input('password')),
                "active" => $request->input('active'),
            ];
         //   dd($dataUserCreate);
            // insert database in user table
            $admin = $this->admin->create($dataAdminUserCreate);
            // insert database to product_tags table
            if ($request->has("role_id")) {
                $role_ids=$request->role_id;
                    $admin->getRoles()->attach($role_ids);
            }
            DB::commit();
            return redirect()->route('admin.user.create')->with("alert", "Thêm admin user thành công");
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.user.create')->with("error", "Thêm admin user không thành công");
        }
    }
    public function edit($id)
    {
        $data = $this->admin->find($id);
        $dataRoles = $this->role->all();
        $dataRolesOfUser=$data->getRoles();
        return view("admin.pages.user.edit", [
            'data' => $data,
            'dataRoles' => $dataRoles,
            'dataRolesOfUser'=>$dataRolesOfUser,
        ]);
    }

    public function update(ValidateEditAdminUser $request, $id)
    {
        try {
            DB::beginTransaction();
            $dataAdminUserUpdate = [
                "name" => $request->input('name'),
                "email" => $request->input('email'),
                "active" => $request->input('active'),
            ];
            if(request()->has('password')){
                $dataAdminUserUpdate['password']=Hash::make($request->input('password'));
            }
            // insert database in product table
            $this->admin->find($id)->update($dataAdminUserUpdate);
            $admin = $this->admin->find($id);

            // insert database to role_users table
            if ($request->has("role_id")) {
                $role_ids=$request->role_id;
                // Các syncphương pháp chấp nhận một loạt các ID để ra trên bảng trung gian. Bất kỳ ID nào không nằm trong mảng đã cho sẽ bị xóa khỏi bảng trung gian.
                $admin->getRoles()->sync($role_ids);
            }
            DB::commit();
            return redirect()->route('admin.user.index')->with("alert", "Sửa admin user thành công");
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.user.index')->with("error", "Sửa admin user không thành công");
        }
    }

    public function destroy($id)
    {
        return $this->deleteTrait($this->admin, $id);
    }
}
