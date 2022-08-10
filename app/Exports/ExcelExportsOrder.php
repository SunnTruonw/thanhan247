<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\OrderManagement\OrderManagement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ExcelExportsOrder implements FromArray, WithHeadings, Responsable, WithStyles, WithColumnWidths, WithColumnFormatting
{

    use Exportable;

    private $fileName  = "user.xlsx";

    private $model;
    private $excelfile;
    private $selectField;
    private $title;
    private $titleField;
    private $start;
    private $end;
    public function __construct()
    {

        $this->model = new OrderManagement();
        $this->selectField = "*";
        $this->title = true;
        $this->titleField = [
            "id" => "STT",
            "order_code" => "Mã Đơn Hàng",
            "customer_name" =>  "Tên người nhận",
            "customer_phone" => "Số điện thoại",
            "customer_address" => "Địa chỉ người nhận",
            "real_money" => "Tiền COD",
            "shipping_fee" => "Tiền Ship",
            "total_money" => "Tổng tiền",
            "refund" => "Tình trạng",
            "note" => "Ghi chú"

        ];
    }

    // public function columnFormats(): array
    // {
    //     return [
    //         'F' => '0,00',
    //         'G' => '0,00',
    //         'H' => '0,00',
    //     ];
    // }

    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 15,
            'C' => 15,
            'D' => 15,
            'E' => 55,
            'F' => 15,
            'G' => 15,
            'H' => 15,
            'I' => 15,
            'J' => 100,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }

    public function columnFormats(): array
    {
        return [
            'F' => '0.00',
        ];
    }




    public function array(): array
    {
        $data = [];
        // dd($this->start,$this->end);
        $orders = $this->model->select($this->selectField)->get();
        if ($orders->count() > 0) {
            foreach ($orders as $value) {
                if (Auth::id() == $value->user_id) {
                    $item = [];
                    $item['id'] = $value->id;
                    $item['order_code'] = $value->order_code;
                    $item['customer_name'] = $value->customer_name;
                    $item['customer_phone'] = $value->customer_phone;
                    $item['customer_address'] = $value->customer_address;
                    $item['real_money'] = number_format($value->real_money, 2);
                    $item['shipping_fee'] = number_format($value->shipping_fee, 2);
                    $item['total_money'] = number_format($value->total_money, 2);
                    $item['refund'] = $value->refund == 0 ? 'Chưa hoàn tiền' : 'Đã hoàn tiền';
                    $item['note'] = $value->note;

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
