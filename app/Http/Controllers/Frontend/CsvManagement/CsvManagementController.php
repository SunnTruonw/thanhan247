<?php

namespace App\Http\Controllers\Frontend\CsvManagement;

use App\Http\Controllers\Controller;
use App\Models\CsvManagement\CsvManagement;
use App\Models\OrderManagement\OrderManagement;
use App\Models\OrderManagementDetail\OrderManagementDetail;
use App\Services\CsvService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExcelExportsOrder;
use App\Exports\ExcelExportsProduct;
use App\Imports\OrderImport;
use App\Models\Contact;
use App\Traits\StorageImageTrait;
use App\Traits\DeleteRecordTrait;




class CsvManagementController extends Controller
{
    use StorageImageTrait, DeleteRecordTrait;

    const FIELD_INSERT_ORDER = [
        'id',
        'order_code',
        'customer_name',
        'customer_phone',
        'customer_address',
        'user_id',
        'total_money',
        'shipping_fee',
        'real_money',
        'condition_id',
        'note',
        'payment_id',
        'shipper_id',
        'package_sum_mass',
        'package_long',
        'package_wide',
        'package_high',
        'debt',
        'refund',
        'created_at',
        'updated_at',
    ];

    const FIELD_UPDATED_ORDER = [
        'id',
        'order_code',
        'customer_name',
        'customer_phone',
        'customer_address',
        'user_id',
        'total_money',
        'shipping_fee',
        'real_money',
        'condition_id',
        'note',
        'payment_id',
        'shipper_id',
        'package_sum_mass',
        'package_long',
        'package_wide',
        'package_high',
        'debt',
        'refund',
        'created_at',
        'updated_at',
    ];

    const FIELD_INSERT_PRODUCT = [
        'id',
        'order_code',
        'product_title',
        'product_image',
        'product_code',
        'product_money',
        'product_mass',
        'product_qty',
        'created_at',
        'updated_at'
    ];
    const FIELD_UPDATED_PRODUCT = [
        'id',
        'order_code',
        'product_title',
        'product_image',
        'product_code',
        'product_money',
        'product_mass',
        'product_qty',
        'created_at',
        'updated_at'
    ];

    protected $model, $order, $orderDetail;
    private $listStatus;

    public function __construct(CsvManagement $model, OrderManagement $order, OrderManagementDetail $orderDetail, Contact $contact)
    {
        $this->model = $model;
        $this->contact = $contact;
        $this->order = $order;
        $this->orderDetail = $orderDetail;
        $this->listStatus = $this->contact->listStatus;
    }

    public function index()
    {
        $user = auth()->guard()->user();
        $csvManagement = $this->model->where('user_id', \Auth::user()->id)
            ->orderByDesc('created_at')
            ->paginate($this->model::PER_PAGE);

        // dd(CsvManagement::all());
        return view('frontend.pages.csv_management.index')->with([
            'user' => $user,
            'csvOrders' => $csvManagement,
            'listStatus' => $this->listStatus,
        ]);
    }

    /**
     * Download csv order
     *  
     * @return view
     */
    public function downloadCsvOrder()
    {
        // dd(123);
        return Excel::download(new ExcelExportsOrder(), 'MauDanhSachDonHang.xlsx');
        return (new ExcelExportsOrder)->download('MauDanhSachDonHang.csv', \Maatwebsite\Excel\Excel::CSV, [
            'Content-Type' => 'text/csv',
        ]);
    }

    /**
     * Download csv order
     * 
     * @param array $request
     * 
     * @return view
     */
    public function downloadCsvProduct()
    {
        // $fileName = config('define.csv.product.title') . '_' . Carbon::today()->format(config('define.format.default.date_csv')) . '.csv';
        // $file = public_path(). "/files/product_sample.csv";
        // if (!file_exists($file)) {
        //     \Log::error($file. ' Not Found');
        //     return false;
        // }
        // $headers = array(
        //   'Content-Type' => 'text/csv; charset=shift-jis',
        // );

        // return response()->download($file, $fileName, $headers);
        return Excel::download(new ExcelExportsProduct(), 'MauDanhSachDonHang.csv');
    }

    /**
     * Import csv
     * 
     * @param array $request
     * 
     * @return mixed
     */
    public function importCsvOrder(Request $request)
    {
        // dd($request->all());
        // dd($request->file('csv_file'));

        try {
            // $file = $request->csv_file;
            // dd($file);
            // $orders = app(CsvService::class)->parseCsv($file, config('define.csv.order.title_header'));
            // $now = date(config('define.format.datetime'));
            // foreach ($orders as $key => $item) {
            //     if ($item['id']) {
            //         $item['updated_at'] = $now;
            //         $this->handleUpdateOrderItem($item);
            //     } else {
            //         $item['created_at'] = $now;
            //         $item['updated_at'] = $now;
            //         $dataInsert = Arr::only($item, self::FIELD_INSERT_ORDER);
            //         $this->handleInsertOrderItem($dataInsert);
            //     }
            // }

            $this->validate($request, [
                'csv_file'  => 'required|mimes:xls,xlsx'
            ]);

            // $path = $request->file('csv_file')->getRealPath();
            $path = $request->file('csv_file')->store('files');

            $dataUploadAvatar = $this->storageTraitUpload($request, "csv_file", "file");
            if (!empty($dataUploadAvatar)) {
                $dataProductCreate["file"] = $dataUploadAvatar["file_path"];
            }

            $data = $this->model->create([
                'file_name' => $dataProductCreate["file"],
                'status' => 1,
                'user_id' => \Auth::user()->id,
            ]);

            $dataExcel = Excel::import(new OrderImport, $request->file('csv_file'));

            return redirect()->route('order_management.index')->with('message', 'Tạo đơn hàng thành công');
        } catch (\Throwable $th) {
            \Log::error($th->getMessage());
            dd($th);
            return redirect()->back()->with('error', $th->getMessage());
        }
    }



    private function handleUpdateOrderItem($item)
    {
        $order = $this->order->whereId($item['id'])->first();
        return $order->update(Arr::only($item, self::FIELD_UPDATED_ORDER));
    }

    private function handleInsertOrderItem($item)
    {
        return $this->order->create($item);
    }

    /**
     * Import csv
     * 
     * @param array $request
     * 
     * @return mixed
     */
    public function importCsvProduct(Request $request)
    {
        try {
            $file = $request->csv_product_file;
            // $products = app(CsvService::class)->parseCsv($file, config('define.csv.product.title_header'));
            // $now = date(config('define.format.datetime'));
            // foreach ($products as $key => $item) {
            //     if ($item['id']) {
            //         $item['updated_at'] = $now;
            //         $this->handleUpdateProductItem($item);
            //     } else {
            //         $item['created_at'] = $now;
            //         $item['updated_at'] = $now;
            //         $dataInsert = Arr::only($item, self::FIELD_INSERT_PRODUCT);
            //         $this->handleInsertProductItem($dataInsert);
            //     }
            // }
            $dataUploadAvatar = $this->storageTraitUpload($request, "csv_product_file", "file");
            if (!empty($dataUploadAvatar)) {
                $dataProductCreate["file"] = $dataUploadAvatar["file_path"];
            }

            $this->model->create([
                'file_name' => $dataProductCreate["file"],
                'status' => 1,
                'user_id' => \Auth::user()->id,
            ]);

            return redirect()->back()->with('message', 'Tạo sản phẩm của đơn hàng thành công');
        } catch (\Throwable $th) {
            \Log::error($th->getMessage());
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function deleteCsvProduct($id)
    {
        return $this->deleteTrait($this->model, $id);
    }

    private function handleUpdateProductItem($item)
    {
        $product = $this->orderDetail->whereId($item['id'])->first();
        return $product->update(Arr::only($item, self::FIELD_UPDATED_PRODUCT));
    }

    private function handleInsertProductItem($item)
    {
        return $this->orderDetail->create($item);
    }
}
