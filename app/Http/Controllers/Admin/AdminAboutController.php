<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\About;
use App\Models\Admin;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Traits\DeleteRecordTrait;
use App\Http\Requests\Admin\About\ValidateAddAbout;
use App\Http\Requests\Admin\About\ValidateEditAbout;

class AdminAboutController extends Controller
{
    //
    use DeleteRecordTrait;
    private $about;
    public function __construct(About $about, Admin $admin)
    {
        $this->about = $about;
        $this->admin = $admin;
    }

    //
    public function index(Request $request)
    {

        $data = $this->about;
        $where = [];
        $orWhere = null;
        if ($request->input('keyword')) {
            $userId=$this->admin->where('name', 'like', '%' . $request->input('keyword') . '%')
            ->orWhere('email', 'like', '%' . $request->input('keyword') . '%')->pluck('id');
            $data = $data->whereIn('admin_id',$userId)->orWhereIn('admin_created_id',$userId);
        }

        $start = $request->input('start');

        if($start){
            $data=$data->whereDate('created_date','>=', $start);
        }
        $end = $request->input('end');
        if($end){
            $data=$data->whereDate('created_date','<=', $end);
        }
        //  if ($request->has('fill_action') && $request->input('fill_action')) {
        //      $key = $request->input('fill_action');

        //      switch ($key) {
        //          case 1:
        //              $where[] = ['type', '=', 1];
        //              break;
        //          case 2:
        //              $where[] = ['type', '=', 2];
        //              break;
        //          default:
        //              break;
        //      }
        //  }
        if ($where) {
            $data = $data->where($where);
        }
        //  dd($orWhere);
        if ($orWhere) {
            $data = $data->orWhere(...$orWhere);
        }
        if ($request->input('order_with')) {
            $key = $request->input('order_with');
            switch ($key) {
                case 'dateASC':
                    $orderby = ['created_at'];
                    break;
                case 'dateDESC':
                    $orderby = [
                        'created_at',
                        'DESC'
                    ];
                    break;
                // case 'usernameASC':
                //     $orderby = [
                //         'username',
                //         'ASC'
                //     ];
                //     break;
                // case 'usernameDESC':
                //     $orderby = [
                //         'username',
                //         'DESC'
                //     ];
                //     break;
                default:
                    $orderby =  $orderby = [
                        'created_at',
                        'DESC'
                    ];
                    break;
            }
            $data = $data->orderBy(...$orderby);
        } else {
            $data = $data->orderBy("created_at", "DESC");
        }

        $data = $data->paginate(30);




        return view("admin.pages.about.list",
            [
                'data' => $data,
                'keyword' => $request->input('keyword') ? $request->input('keyword') : "",
                'start' => $request->input('start') ? $request->input('start') : "",
                'end' => $request->input('end') ? $request->input('end') : "",
                'order_with' => $request->input('order_with') ? $request->input('order_with') : "",
                'fill_action' => $request->input('fill_action') ? $request->input('fill_action') : "",
            ]
        );
    }
    public function create(Request $request = null)
    {
        $admins = $this->admin->whereNotIn('id', [1])->get();

        return view(
            "admin.pages.about.add",
            [
                'request' => $request,
                'admins' => $admins
            ]
        );
    }
    public function store(ValidateAddAbout $request)
    {
        try {
            DB::beginTransaction();
            $dataAboutCreate = [
                "name" => $request->name,
                'created_date' => $request->created_date,
                'to' => $request->to,
                'description' => $request->description,
                "admin_id" => $request->admin_id,
                "admin_created_id" => auth()->guard('admin')->id()
            ];
            //dd($dataAboutCreate);
            $about = $this->about->create($dataAboutCreate);
            //  dd($about);
            DB::commit();
            return redirect()->route("admin.about.index")->with("alert", "Thêm  thành công");
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.about.index')->with("error", "Thêm  không thành công");
        }
    }
    public function edit($id)
    {
        $data = $this->about->find($id);
        $admins = $this->admin->whereNotIn('id', [1])->get();
        return view("admin.pages.about.edit", [
            'data' => $data,
            'admins' => $admins
        ]);
    }
    public function update(ValidateEditAbout $request, $id)
    {
        try {
            DB::beginTransaction();
            $dataAboutUpdate = [
                "name" => $request->name,
                'created_date' => $request->created_date,
                'to' => $request->to,
                'description' => $request->description,
                "admin_id" => $request->admin_id,
                "admin_created_id" => auth()->guard('admin')->id()
            ];
            $this->about->find($id)->update($dataAboutUpdate);
            DB::commit();
            return redirect()->route("admin.about.index")->with("alert", "Sửa  thành công");
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.about.index')->with("error", "Sửa  không thành công");
        }
    }
    public function destroy($id)
    {
        return $this->deleteTrait($this->about, $id);
    }
}
