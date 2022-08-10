<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\OrderManagement\OrderManagement;
use App\Models\OrderManagementDetail\OrderManagementDetail;
use Illuminate\Support\Facades\Auth;

class ExcelExportsProduct implements FromArray, WithHeadings
{
    private $model;
    private $excelfile;
    private $selectField;
    private $title;
    private $titleField;
    private $start;
    private $end;
    public function __construct()
    {

        $this->model = new OrderManagementDetail();
        $this->selectField = "*";
        $this->title = true;
        $this->titleField = [
            "id" => "STT",
            "order_code" => "Mã Đơn Hàng",
            "product_title" =>  "Tên sản phẩm",
            // "product_image" => "Hình ảnh",
            "product_code" => "Mã sản phẩm",
            "product_qty" => "Số lượng",


        ];
    }
    public function array(): array
    {

        $order_management = OrderManagement::where('user_id', Auth::id())->first();
        $data = [];
        // dd($this->start,$this->end);
        $orders = $this->model->select($this->selectField)->get();
        if ($orders->count() > 0) {
            foreach ($orders as $value) {
                if ($value->order_code == $order_management->order_code) {
                    $item = [];
                    $item['id'] = $value->id;

                    $item['order_code'] = $value->order_code;
                    $item['product_title'] = $value->product_title;
                    // $item['product_image'] = '<a width="100px" href="' . $value->product_image . '" target="_blank" rel="noopener noreferrer"><img src="' . $value->product_image . '"/></a>';
                    $item['product_code'] = $value->product_code;

                    $item['product_qty'] = $value->product_qty;

                    array_push($data, $item);
                }
            }
        }

        // dd($data);
        return $data;
    }
    // add title for file export
    public function headings(): array
    {
        if ($this->title) {
            return $this->titleField;
        } else {
            return [];
        }
    }
}
