<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Traits\DeleteRecordTrait;
use App\Http\Requests\Admin\Permission\ValidateAddPermission;
use App\Http\Requests\Admin\Permission\ValidateEditPermission;
class AdminPermissionController extends Controller
{
    //
    use DeleteRecordTrait;
    private $permission;
    public function __construct(Permission $permission)
    {
        $this->permission = $permission;
    }

    public function index()
    {
        $data = $this->permission->setAppends(['breadcrumb'])->where('parent_id',0)->orderBy("created_at", "desc")->paginate(15);
        return view(
            "admin.pages.permission.list",
            [
                'data' => $data
            ]
        );
    }
    public function create(Request $request)
    {
        if($request->has("parent_id")){
            $htmlselect = $this->permission->getHtmlOptionAddWithParent($request->parent_id);
        }else{
            $htmlselect = $this->permission->getHtmlOption();
        }

        return view(
            "admin.pages.permission.add",
            [
                'option' => $htmlselect,
                'request' => $request
            ]
        );
    }
    public function store(ValidateAddPermission $request)
    {

        $dataPermissionCreate=[
            "name"=>$request->input('name'),
            "description"=>$request->input('description'),
            "parent_id"=>$request->input('parentId'),
            "key_code"=>$request->input('key_code'),
          ];
        $this->permission->create($dataPermissionCreate);
        return redirect()->route("admin.permission.create",['parent_id'=>$request->parentId])->with("alert", "Thêm permission thành công");
    }
    public function edit($id)
    {
        $data = $this->permission->find($id);
        $parentId = $data->parent_id;
        $htmlselect = Permission::getHtmlOptionEdit($parentId,$id);
        return view("admin.pages.permission.edit", [
            'option' => $htmlselect,
            'data' => $data
        ]);
    }
    public function update(ValidateEditPermission $request, $id)
    {
        $this->permission->find($id)->update([
            'name' => $request->input('name'),
            "description"=>$request->input('description'),
            "parent_id"=>$request->input('parentId'),
            "key_code"=>$request->input('key_code'),
        ]);
        return redirect()->route("admin.permission.index")->with("alert", "Sửa permission thành công");
    }
    public function destroy($id)
    {
        return $this->deleteTrait($this->permission, $id);
    }


/*


    public function index()
    {
        $data = $this->permission->orderBy("created_at", "ASC")->paginate(10);
        return view(
            "admin.pages.permission.list",
            [
                'data' => $data
            ]
        );
    }
      public function create(Request $request = null)
    {
        $htmlselect = $this->permission->getHtmlOption();
        $permissionsParent=config('permissions.table_module');
        $permissionsChildrent=config('permissions.module_childrent');
        return view(
            "admin.pages.permission.add",
            [
                'option' => $htmlselect,
                'request' => $request,
                'permissionsParent'=>$permissionsParent,
                'permissionsChildrent'=>$permissionsChildrent,
            ]
        );
    }

    public function store(ValidateAddPermission $request)
    {
        try {
            DB::beginTransaction();
            $permission=$this->permission->create([
                'name'=>$request->input('module_parent'),
                'description'=>$request->input('module_parent'),
                'parent_id'=>0,
            ]);
            foreach($request->input('module_childrent') as $value){
                $this->permission->create([
                    'name'=>$value,
                    'description'=>$value,
                    'parent_id'=>$permission->id,
                    "key_code"=>$request->input('module_parent').'_'.$value,
                ]);
            }
            DB::commit();
            return redirect()->route("admin.permission.store")->with("alert", "add completed");
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route("admin.permission.store");
        }

    }

*/
}
