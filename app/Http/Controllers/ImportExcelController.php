<?php

namespace App\Http\Controllers;

use App\Models\OrderManagement\OrderManagement;
use Illuminate\Http\Request;
use DB;
use Excel;

class ImportExcelController extends Controller
{
    function import(Request $request)
    {
        $this->validate($request, [
            'select_file'  => 'required|mimes:xls,xlsx'
        ]);

        $path = $request->file('select_file')->getRealPath();

        $dataExcel = Excel::load($path)->get();

        if ($dataExcel->count() > 0) {
            foreach ($dataExcel->toArray() as $key => $value) {
                foreach ($value as $row) {
                    $insert_data[] = array(
                        'customer_name'  => $row['customer_name'],
                        'customer_phone'   => $row['customer_phone'],
                        'customer_address'   => $row['customer_address'],
                        'real_money'   => $row['real_money'],
                        'shipping_fee'    => $row['shipping_fee'],
                        'total_money'  => $row['total_money'],
                        'note2'   => $row['note2'],
                        'condition_id'   => 1,
                    );
                }
            }

            if (!empty($insert_data)) {
                OrderManagement::insert($insert_data);
            }
        }
        return back()->with('success', 'Excel Data Imported successfully.');
    }
}
