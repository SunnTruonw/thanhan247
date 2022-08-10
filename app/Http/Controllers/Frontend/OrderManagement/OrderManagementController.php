<?php

namespace App\Http\Controllers\Frontend\OrderManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\CreateOrderRequest;
use App\Models\City;
use App\Models\Commune;
use App\Models\Condition\Condition;
use App\Models\District;
use App\Models\OrderManagement\OrderManagement;
use App\Models\OrderManagementDetail\OrderManagementDetail;
use App\Services\CsvService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\StorageImageTrait;
use App\Traits\DeleteRecordTrait;

use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\StreamedResponse;

class OrderManagementController extends Controller
{
    use StorageImageTrait, DeleteRecordTrait;
    protected $condition, $model, $cities, $orderDetail, $districts, $commune;

    public function __construct(
        Condition $condition,
        OrderManagement $orderManagement,
        City $cities,
        District $districts,
        Commune $commune,
        OrderManagementDetail $orderDetail
    ) {
        $this->condition = $condition;
        $this->model = $orderManagement;
        $this->cities = $cities;
        $this->orderDetail = $orderDetail;
        $this->districts = $districts;
        $this->commune = $commune;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $params = request()->all();
        $user = auth()->guard()->user();

        $orders = $user->orders()
            ->filterForm()
            ->handleSort()
            ->when($params, function ($query) use ($params) {
                if (isset($params['start']) && isset($params['end'])) {
                    $query->whereBetween('created_at', [$params['start'], $params['end']]);
                } else {
                    $query->when(isset($params['start']), function ($q) use ($params) {
                        $q->where('created_at', '>=', $params['start']);
                    })
                        ->when(isset($params['end']), function ($q) use ($params) {
                            $q->where('created_at', '<=', $params['end']);
                        });
                }
            })
            ->paginate($this->model::PER_PAGE)
            ->appends(request()->query());


        // dd($orders);
        $total = $user->orders()->count();
        $conditions = $this->condition->all();
        $totalOrderForCondition = $user->orders()->select($this->condition->raw('count(condition_id) as total'), 'condition_id')->groupBy('condition_id')->get();

        $results = $user->orders()
            // ->filterForm()
            // ->handleSort()
            ->get();

        $totalSingle = $results->count();
        $totalCode = array_sum(array_column($results->toArray(), 'real_money'));
        $totalThanhToan = array_sum(array_column($results->toArray(), 'total_money'));
        $totalRoot = array_sum(array_column($results->toArray(), 'total_money'));
        $totalShip = array_sum(array_column($results->toArray(), 'shipping_fee'));

        $now = new \Carbon\Carbon;


        return view('frontend.pages.oder_management.index')->with([
            'user' => $user,
            'start' => $request->input('start') ? $request->input('start') : "",
            'end' => $request->input('end') ? $request->input('end') : $now->now()->addDays(1)->format('Y-m-d'),
            'totalCode' => $totalCode,
            'totalThanhToan' => $totalThanhToan,
            'totalRoot' => $totalRoot,
            'conditions' => $conditions,
            'totalSingle' => $totalSingle,
            'totalShip' => $totalShip,
            'orders' => $orders,
            'total' => $total,
            'totalOrderForCondition' => $totalOrderForCondition
        ]);
    }

    public function history()
    {
        $user = auth()->guard()->user();
        $orders = $user->orders()
            ->filterForm()
            ->handleSort()
            ->paginate($this->model::PER_PAGE)
            ->appends(request()->query());

        $total = $user->orders()->count();
        $conditions = $this->condition->all();
        $totalOrderForCondition = $user->orders()->select($this->condition->raw('count(condition_id) as total'), 'condition_id')->groupBy('condition_id')->get();

        $results = $user->orders()
            ->filterForm()
            ->handleSort()
            ->get();

        // dd($results);
        $totalCode = array_sum(array_column($results->toArray(), 'real_money'));
        $totalThanhToan = array_sum(array_column($results->toArray(), 'total_money'));
        $totalRoot = array_sum(array_column($results->toArray(), 'total_money'));


        // dd($totalThanhToan);
        return view('frontend.pages.oder_management.history')->with([
            'user' => $user,
            'totalCode' => $totalCode,
            'totalThanhToan' => $totalThanhToan,
            'totalRoot' => $totalRoot,
            'conditions' => $conditions,
            'orders' => $orders,
            'total' => $total,
            'totalOrderForCondition' => $totalOrderForCondition
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = auth()->guard()->user();
        $cities = $this->cities->all();

        return view('frontend.pages.oder_management.create')
            ->with([
                'user' => $user,
                'cities' => $cities
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $city_name = $this->cities->find($request->city)->name;
        $district_name = $this->districts->find($request->district)->name;
        $ward_name = $this->commune->find($request->wards)->name;
        $orderCode = substr(md5(mt_rand()), 0, 6);

        $dataUploadAvatar = $this->storageTraitUpload($request, "file", "file");
        if (!empty($dataUploadAvatar)) {
            $dataProductCreate["file"] = $dataUploadAvatar["file_path"];
        }

        // dd($dataProductCreate['file']);

        $order = $this->model->create([
            'order_code' => $orderCode,
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'customer_address' => $request->customer_address . ' ' . $ward_name . ' ' . $district_name . ' ' . $city_name,
            'user_id' => auth()->guard()->user()->id,
            'total_money' => str_replace(",", "", $request['total_money']),
            'real_money' => str_replace(",", "", $request['real_money']),
            'shipping_fee' => str_replace(",", "", $request['shipping_fee']),
            'note' => $request->note_delivery . ' ' . $request->customer_code . ' ' . $request->note,
            'file' => $dataProductCreate["file"] ?? '',


            'package_sum_mass' => $request->package_sum_mass,
            'package_long' => $request->package_long,
            'package_wide' => $request->package_wide,
            'package_high' => $request->package_high,
        ]);

        // dd($order);


        if ($order) {
            for ($i = 0; $i < count($request->product_title); $i++) {
                $image = $request['product_image'];
                $filename = "";
                if (isset($image)) {
                    $destinationPath = 'images/';
                    $filename = date('YmdHis') . "." . $image[$i]->getClientOriginalName();
                    $image[$i]->move($destinationPath, $filename);
                }
                $data = $this->orderDetail->create([
                    'order_code' => $orderCode,
                    'product_title' => $request->product_title[$i],
                    'product_code' => $request->product_code[$i],
                    'product_image' => $filename,

                    'product_mass' => $request->product_mass[$i],
                    'product_qty' =>  $request->product_qty[$i],
                    'product_money' =>  str_replace(",", "", $request->product_money[$i]),
                ]);
            }
            return redirect()->route('order_management.index')->with('message', 'Tạo đơn hàng thành công');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function deleteOrderManage(Request $request, $id)
    {
        return $this->deleteTrait($this->model, $id);
    }

    /**
     * get the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function getShipping($val)
    {
        $shipping_fees = [];
        if ($val == 0) {
            $shipping_fees[] = 0;
        }
        if (0 < $val && $val < 3) {
            $data = \DB::table('shipping_fees')->where('id', 1)->get();
            $shipping_fees[] = $data[0]->total_money;
        }
        if (3 < $val && $val < 6) {
            $data = \DB::table('shipping_fees')->where('id', 2)->get();
            $shipping_fees[] = $data[0]->total_money;
        }
        if (6 < $val && $val < 8) {
            $data = \DB::table('shipping_fees')->where('id', 3)->get();
            $shipping_fees[] = $data[0]->total_money;
        }
        if (8 < $val && $val < 12) {
            $data = \DB::table('shipping_fees')->where('id', 4)->get();
            $shipping_fees[] = $data[0]->total_money;
        }
        if (12 < $val && $val < 15) {
            $data = \DB::table('shipping_fees')->where('id', 5)->get();
            $shipping_fees[] = $data[0]->total_money;
        }
        if ($val > 15) {
            $shipping_fees[] = 50000.00;
        }
        return response()->json($shipping_fees);
    }
}
