<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Point;
use App\Models\User;
use App\Models\Pay;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exports\ExcelExportsDatabasePay;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\Admin\ValidateExportExcelPay;

class AdminPayController extends Controller
{
    //
    private $numberChild = 3;
    private $typePoint;
    private $rose;
    private $user;
    private $pay;
    private $typePay;
    public function __construct(Point $point, User $user, Pay $pay)
    {
        $this->typePoint = config('point.typePoint');
        $this->rose = config('point.rose');
        $this->typePay = config('point.typePay');
        $this->user = $user;
        $this->point = $point;
        $this->pay = $pay;
    }
    public function index(Request $request)
    {

        $totalPay = $this->pay->all()->count();
        $data = $this->pay;

        $where = [];
        $whereIn = [];
        $orWhere = null;
        if ($request->input('keyword')) {
           // dd($request->input('keyword'));
            $userId=$this->user->where([
                ['username', 'like', '%' . $request->input('keyword') . '%'],
            ])->orWhere([
                ['name', 'like', '%' . $request->input('keyword') . '%'],
            ])->pluck('id')->toArray();
         //   dd($userId);
             //   dd();
            $whereIn[] = ['user_id',   $userId];
         //   dd($userId);
         //  dd( $data = $data->whereIn('user_id',   $userId)->get());
        }
        if ($request->has('fill_action') && $request->input('fill_action')) {
            $key = $request->input('fill_action');

            switch ($key) {
                case 'handle':
                    $where[] = ['status', '=', 1];
                    break;
                case 'complate':
                    $where[] = ['status', '=', 2];
                    break;
                case 'cancel':
                    $where[] = ['status', '=', 3];
                    break;

                default:
                    break;
            }
        }
        if ($where) {
            $data = $data->where($where);
        }
        if ($whereIn) {
            foreach ($whereIn as $w) {
                $data = $data->whereIn(...$w);
            }
        }
      //  dd($data->get());
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
                case 'statusASC':
                    $orderby = [
                        'status',
                        'ASC'
                    ];
                    break;
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

        $data = $data->paginate(15);


        // $data = $this->pay->where([
        //     'active' => 1,
        // ])->orderBy("created_at", "desc")->paginate(15);

        return view(
            "admin.pages.pay.list",
            [
                'data' => $data,
                'typePay' => $this->typePay,
                'totalPay'=>$totalPay,
                'keyword' => $request->input('keyword') ? $request->input('keyword') : "",
                'order_with' => $request->input('order_with') ? $request->input('order_with') : "",
                'fill_action' => $request->input('fill_action') ? $request->input('fill_action') : "",
            ]
        );
    }

    public function updateDrawPoint(Request $request)
    {
        try {
            DB::beginTransaction();
            if ($request->has('type') && $request->has('id')) {
                $type = $request->type;
                $id = $request->id;
                $pay = $this->pay->find($id);

                switch ($type) {
                    case 'complate':
                        $statusUpdate = 2;
                        break;
                    case 'error':
                        $statusUpdate = 3;
                        $user = $this->user->find($id);
                        $user->points()->create([
                            'type' => $this->typePoint[7]['type'],
                            'point' => $pay->point,
                            'active' => 1,
                        ]);
                        break;
                    default:
                        return;
                        break;
                }

                $resultUpdate = $pay->update([
                    'status' => $statusUpdate,
                ]);
            }
            $pay = $this->pay->find($id);
            DB::commit();
            return response()->json([
                "code" => 200,
                "html" => $this->typePay[$pay->status]['name'],
                "message" => "success"
            ], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }
    }
    public function updateDrawPointAll(Request $request)
    {
        //   dd($request->has('type') && $request->has('id'));

        if ($request->has('type') && $request->has('id')) {
            $type = $request->type;
            $listId = $request->get('id');
            switch ($type) {
                case 'complate':
                    $statusUpdate = 2;
                    break;
                case 'error':
                    $statusUpdate = 3;
                    break;
                default:
                    return;
                    break;
            }
            try {
                DB::beginTransaction();
                $dem = 0;
                foreach ($listId as $id) {
                    $pay = $this->pay->find($id);
                    $resultUpdate = $pay->update([
                        'status' => $statusUpdate,
                    ]);
                    if ($resultUpdate) {
                        $dem++;
                    }
                    switch ($type) {
                        case 'complate':
                            $numberUpdate = "Đã chuyển " . $dem . " yêu cầu rút tiền sang trạng thái hoàn thành";
                            break;
                        case 'error':
                            $user = $this->user->find($id);
                            $user->points()->create([
                                'type' => $this->typePoint[7]['type'],
                                'point' => $pay->point,
                                'active' => 1,
                            ]);
                            break;
                        default:
                            return;
                            break;
                    }
                }

                switch ($type) {
                    case 'complate':
                        $numberUpdate = "Đã chuyển " . $dem . " yêu cầu rút tiền sang trạng thái hoàn thành";
                        break;
                    case 'error':
                        $numberUpdate = "Đã chuyển " . $dem . " yêu cầu rút tiền sang trạng thái lỗi và hoàn điểm lại";

                        break;
                    default:
                        return;
                        break;
                }

                DB::commit();
                return redirect()->route('admin.pay.index')->with("alert", "Xác nhận  thành công")->with("numberUpdate", $numberUpdate);
            } catch (\Exception $exception) {
                //throw $th;
                DB::rollBack();
                Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
                return redirect()->route('admin.pay.index')->with("error", "Xác nhận không thành công");
            }
        }
    }

    public function excelExportDatabase(ValidateExportExcelPay $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');
        return Excel::download(new ExcelExportsDatabasePay($start, $end), 'pay.xlsx');
    }
}
