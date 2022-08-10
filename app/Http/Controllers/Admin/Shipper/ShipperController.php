<?php

namespace App\Http\Controllers\Admin\Shipper;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Shipper\CreateAndUpdateShipperRequest;
use App\Models\Condition\Condition;
use App\Models\OrderManagement\OrderManagement;
use App\Models\Shipper\Shipper;
use Illuminate\Http\Request;

class ShipperController extends Controller
{
    protected $model, $orderManagement;

    public function __construct(Shipper $model, OrderManagement $orderManagement)
    {
        $this->model = $model;
        $this->orderManagement = $orderManagement;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shippers = $this->model
                    ->handleSort()
                    ->filterForm()
                    ->paginate($this->model::PER_PAGE)
                    ->appends(request()->query());

        $countDeliveryOrder = [];
        foreach ($shippers as $key => $shipper) {
            $count = $shipper->order()->where('condition_id', Condition::ORDER_COMPLETE)->get()->count();
            $countDeliveryOrder[] = $count;
        }
        
        return view('admin.pages.shipper.index')->with([
            'shippers' => $shippers,
            'counts' => $countDeliveryOrder
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.shipper.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateAndUpdateShipperRequest $request)
    {
        try {
            $this->model->create($request->all());
            
            return redirect()->back()->with('message', 'Thêm shipper thành công'); 
        } catch (\Throwable $th) {
            \Log::error($th->getMessage());
            return redirect()->back()->with('error', 'Lỗi hệ thống vui lòng thử lại sau!');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $shipper = $this->model->findOrFail($id);

        if ($shipper) {
            return view('admin.pages.shipper.edit')->with([
                'shipper' => $shipper
            ]);
        }else {
            return redirect()->back()->with('error', 'Lỗi hệ thống');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $this->model->where('id', $id)
                    ->update([
                        'name' => $request['name'],
                        'email' => $request['email'],
                        'phone' => $request['phone'],
                        'address' => $request['address'],
                        'license_plates' => $request['license_plates'],
                    ]);

            return redirect()->route('admin.shipper.index')->with('message', 'Cập nhật thành công!');
        } catch (\Throwable $th) {
            \Log::error($th->getMessage());
            return redirect()->back()->with('error', 'Lỗi hệ thống!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->model->destroy([$id]);

        return redirect()->back()->with('message', 'Xóa nhân viên giao hàng thành công');
    }
}
