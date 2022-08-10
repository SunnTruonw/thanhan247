<?php

namespace App\Http\Controllers\Admin\OrderManagement;

use App\Http\Controllers\Controller;
use App\Models\Condition\Condition;
use App\Models\OrderManagement\OrderManagement;
use App\Models\Shipper\Shipper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;



class OrderManagementController extends Controller
{
    protected $model, $condition, $shipper;

    public function __construct(OrderManagement $model, Condition $condition, Shipper $shipper)
    {
        $this->model = $model;
        $this->condition = $condition;
        $this->shipper = $shipper;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $params = request()->all();

        // dd($params);

        // dd(explode('TA_', $params['user_id']));
        $orderMs = $this->model
            ->handleSort()
            // ->when(isset($params['customer_name']), function ($query) use ($params) {
            //     $query->join('users', 'order_managements.user_id', 'users.id')
            //         ->where('customer_name', 'LIKE', '%' . $params['customer_name'] . '%');
            //     // $query->where('customer_name', 'LIKE', $params['customer_name']);
            // })
            ->when(isset($params['user_id']), function ($query) use ($params) {
                $query->join('users', 'order_managements.user_id', 'users.id')
                    ->whereIn('user_id', explode('TA_', $params['user_id']));
                // ->where('user_id', 'LIKE', '%' . $params['user_id'] . '%');
            })
            ->when(isset($params['name_user']), function ($query) use ($params) {
                $query->join('users', 'order_managements.user_id', 'users.id')
                    ->where('name', 'LIKE', '%' . $params['name_user'] . '%');
            })
            ->when(isset($params['total_money']), function ($query) use ($params) {
                $total = explode(',', $params['total_money']);

                $query->join('users', 'order_managements.user_id', 'users.id')
                    ->where('total_money', $params['total_money'] . '.00');
            })
            ->when(isset($params['ship_name']), function ($query) use ($params) {
                // $query->join('shippers', 'order_managements.shipper_id', 'shippers.id')
                //     ->where('ship_name', 'LIKE', '%' . $params['ship_name'] . '%');
                // $query->where('customer_name', 'LIKE', $params['customer_name']);

                $idProTran = Shipper::where([
                    ['name', 'like', '%' . $params['ship_name'] . '%']
                ])->pluck('id');

                $query->whereIn('shipper_id', $idProTran);

                // dd($dataPro->get());
            })
            ->when($params, function ($query) use ($params) {
                if (isset($params['start_date']) && isset($params['end_date'])) {
                    $query->whereBetween('created_at', [$params['start_date'], $params['end_date']]);
                } else {
                    $query->when(isset($params['start_date']), function ($q) use ($params) {
                        $q->where('created_at', '>=', $params['start_date']);
                    })
                        ->when(isset($params['end_date']), function ($q) use ($params) {
                            $q->where('created_at', '<=', $params['end_date']);
                        });
                }
            })

            ->filterForm();


        // ->paginate($this->model::PER_PAGE)


        $ordersData = $orderMs->get();

        $orders = $orderMs->paginate(30)
            ->appends(request()->query());


        // dd($orders);
        // $conditions = $this->condition->where('id', '<>', 2)->get();
        $conditions = $this->condition->all();

        $shippers = $this->shipper->all();
        $totalOrder = $ordersData->count();

        // $orderData = $this->model
        //     ->get();

        $totalCode = array_sum(array_column($ordersData->toArray(), 'real_money'));
        $totalShip = array_sum(array_column($ordersData->toArray(), 'shipping_fee'));
        $totalRoot = array_sum(array_column($ordersData->toArray(), 'total_money'));


        // dd($now);


        return view('admin.pages.order_management.index')->with([
            'orders' => $orders,

            'totalCode' => $totalCode,
            'totalShip' => $totalShip,
            'totalRoot' => $totalRoot,
            'conditions' => $conditions,
            'shippers' => $shippers,
            'total' => $totalOrder,
        ]);
    }



    private function searchOrder($params)
    {
        $select = ['order_managements.*'];
        $query = $this->model;

        if (isset($params['start_date']) && isset($params['end_date'])) {
            $query = $query->whereBetween('collection_date', [$params['start_date'], $params['end_date']]);
        } else {
            $query = $query->when(isset($params['start_date']), function ($q) use ($params) {
                $q->where('collection_date', '>=', $params['start_date']);
            })
                ->when(isset($params['end_date']), function ($q) use ($params) {
                    $q->where('collection_date', '<=', $params['end_date']);
                });
        }

        return $query->select($select);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = $this->model->findOrFail($id);

        return view('admin.pages.order_management.show')->with([
            'order' => $order,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order_management = $this->model->find($id);
        return view('admin.pages.order_management.edit')->with([
            'order_management' => $order_management,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function updateOrderManagement(Request $request, $id)
    {
        // dd($request->all());
        try {
            DB::beginTransaction();
            $dataOrderManagementUpdate = [
                'total_money' => str_replace(",", "", $request['total_money']),
                'real_money' => str_replace(",", "", $request['real_money']),
                'shipping_fee' => str_replace(",", "", $request['shipping_fee']),
                'package_long' => $request->package_long,
                "package_wide" => $request->package_wide,
                "package_high" => $request->package_high,
            ];

            // dd($dataOrderManagementUpdate);
            $this->model->find($id)->update($dataOrderManagementUpdate);
            DB::commit();
            return redirect()->route("admin.order_management.show", ['id' => $id])->with("alert", "Sửa chi tiết đơn hàng thành công");
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.order_management.show', ['id' => $id])->with("error", "Sửa chi tiết đơn hàng không thành công");
        }
    }

    public function update(Request $request, $id)
    {
        $data =  $this->model->where('id', $id)->first();

        $condition_id = $data->condition_id;
        $shipper_id = $data->shipper_id;
        if ($condition_id == 3 || $condition_id == 4 || $request['condition_id'] == 3 || $request['condition_id'] == 4) {
            if (!$shipper_id) {
                return redirect()->back()->with('error', 'Chưa chọn shipper');
            }
        }
        $this->model->where('id', $id)->update(
            [
                'condition_id' => $request['condition_id'],
                'note2' => $request->input('note2')
            ]
        );

        return redirect()->back()->with('message', 'Cập nhật thành công');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateShipper(Request $request, $id)
    {
        $this->model->where('id', $id)->update([
            'shipper_id' => $request['shipper_id'],
            'condition_id' => 3,
        ]);

        return redirect()->back()->with('message', 'Cập nhật người giao hàng thành công');
    }

    public function updateTotalShipper(Request $request, $id)
    {
        // dd($request->all());
        $validator = \Validator::make($request->all(), [
            'totalCod' => "required|numeric"
        ]);

        // dd($validator);
        if ($validator->fails()) {
            return redirect()->back()->with("error", "Số tiền bạn nhập không hợp lệ");
        }
        $data = $this->model->find($id);
        $total = $data->real_money + $request['totalCod'];
        $this->model->where('id', $id)->update([
            'shipping_fee' => str_replace(",", "", $request['totalCod']),
            'total_money' => str_replace(",", "", $total),
        ]);

        return redirect()->back()->with('message', 'Cập nhật tiền ship hàng thành công');
    }

    public function updateAddressCustomer(Request $request, $id)
    {
        $this->model->where('id', $id)->update([
            'customer_address' => $request->input('customer_addressM'),
        ]);

        return redirect()->back()->with('message', 'Cập nhật thành công!');
    }

    public function updateTotalCode(Request $request, $id)
    {
        // dd($request->all());
        $validator = \Validator::make($request->all(), [
            'totalCode' => "required|numeric"
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with("error", "Số tiền bạn nhập không hợp lệ");
        }
        $data = $this->model->find($id);
        $total = $data->shipping_fee + $request['totalCode'];
        $this->model->where('id', $id)->update([
            'real_money' => str_replace(",", "", $request['totalCode']),
            'total_money' => str_replace(",", "", $total),
        ]);

        return redirect()->back()->with('message', 'Cập nhật tiền cod thành công');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateRefund(Request $request, $id)
    {
        $this->model->where('id', $id)->update([
            'refund' => $this->model::REFUNDED,
            'condition_id' => 4,
        ]);

        return redirect()->back()->with('message', 'Cập nhật thành công!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateDebt(Request $request, $id)
    {
        $this->model->where('id', $id)->update([
            'debt' => $this->model::PAID,
            'condition_id' => 4,
        ]);

        return redirect()->back()->with('message', 'Cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->model->findOrFail($id)
            ->orderDetail
            ->each(function ($orderDetail, $key) {
                $orderDetail->delete();
            });
        $this->model->destroy([$id]);

        return redirect()->back()->with('message', 'Xóa đơn hàng và chi tiết đơn hàng thành công!');
    }

    public function deleteMultiple(Request $request)
    {
        // dd($request['condition_id']);
        if ($request->idsArr) {
            $idsArr = $request->idsArr;
            // dd($idsArr);
            $data = $this->model->whereIn('id', $idsArr)->update(
                [
                    'condition_id' => $request['condition_id'],
                ]
            );

            // OrderManagement::whereIn('id', explode(",", $ids))->delete();
            return response()->json([
                'status' => true,
                'message' => "Chuyển đổi tất đơn hàng thành công.",
                'data' => $data
            ]);
        }
    }

    public function loadStatusOrder($id)
    {
        // dd($id);
        $model   =  $this->model->find($id);
        $status = $model->status;

        if ($status) {
            $statusUpdate = 0;
        } else {
            $statusUpdate = 1;
        }

        // dd($statusUpdate);
        $updateResult =  $model->update([
            'status' => $statusUpdate,
        ]);

        $model   =  $this->model->find($id);
        if ($updateResult) {
            return response()->json([
                "code" => 200,
                "html" => view('admin.components.load-change-status-order', ['data' => $model, 'type' => 'sản phẩm'])->render(),
                "message" => "success"
            ], 200);
        } else {
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }
    }

    public function loadStatusOrderShip($id)
    {
        $model   =  $this->model->find($id);
        $status_ship = $model->status_ship;

        if ($status_ship) {
            $status_shipUpdate = 0;
        } else {
            $status_shipUpdate = 1;
        }
        $updateResult =  $model->update([
            'status_ship' => $status_shipUpdate,
        ]);

        $model   =  $this->model->find($id);
        // dd($model->status_ship);
        if ($updateResult) {
            return response()->json([
                "code" => 200,
                "html" => view('admin.components.load-change-status-order-ship', ['data' => $model, 'type' => 'sản phẩm'])->render(),
                "message" => "success"
            ], 200);
        } else {
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }
    }
}
