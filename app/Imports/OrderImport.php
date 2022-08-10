<?php

namespace App\Imports;

use App\Models\OrderManagement\OrderManagement;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class OrderImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // dd($row);
        return  new OrderManagement([
            'order_code' => substr(md5(mt_rand()), 0, 6),
            'customer_name'     => $row['ten_nguoi_nhan'] ?? '',
            'customer_phone'   => $row['so_dien_thoai'] ?? '',
            'customer_address'   => $row['dia_chi_nguoi_nhan'] ?? '',
            'real_money'   => str_replace(",", "", $row['tien_cod']) ?? 0,
            'shipping_fee'    => str_replace(",", "", $row['tien_ship']) ?? 0,
            'total_money'  => str_replace(",", "", $row['tong_tien']) ?? 0,
            'condition_id'   => 1,
            'note'   => $row['ghi_chu'] ?? '',

            'file' => '',
            'user_id' => auth()->guard()->user()->id ?? 0,
            'package_sum_mass' => 0,
            'package_long' => 0,
            'package_wide' => 0,
            'package_high' => 0,
        ]);

        // dd($data);
    }
}
