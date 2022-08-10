<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bank;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Traits\DeleteRecordTrait;
use App\Http\Requests\Admin\Bank\ValidateAddBank;
use App\Http\Requests\Admin\Bank\ValidateEditBank;

class AdminBankController extends Controller
{
    use DeleteRecordTrait;
    private $bank;
    public function __construct(Bank $bank)
    {
        $this->bank = $bank;
    }
    public function index()
    {
        $data = $this->bank->orderBy("created_at", "desc")->paginate(15);
        return view(
            "admin.pages.bank.list",
            [
                'data' => $data
            ]
        );
    }
    public function create(Request $request )
    {

        return view(
            "admin.pages.bank.add",
            [
                'request' => $request
            ]
        );
    }
    public function store(ValidateAddBank $request)
    {

        $dataBankCreate=[
            "name"=>$request->input('name'),
            "active"=>$request->input('active'),
            "admin_id"=>auth()->guard('admin')->id()
          ];
        if($this->bank->create($dataBankCreate)){
            return redirect()->route("admin.bank.create")->with("alert", "Thêm bank thành công");
        }else{
            return redirect()->route("admin.bank.create")->with("error", "Thêm bank không thành công");
        }
    }
    public function edit($id)
    {
        $data = $this->bank->find($id);
        return view("admin.pages.bank.edit", [
            'data' => $data
        ]);
    }
    public function update(ValidateEditBank $request, $id)
    {
        $this->bank->find($id)->update([
            'name' => $request->input('name'),
            'active' => $request->input('active'),
        ]);
        return redirect()->route("admin.bank.index")->with("alert", "Sửa bank thành công");
    }
    public function destroy($id)
    {
        return $this->deleteCategoryRecusiveTrait($this->bank, $id);
    }
}
