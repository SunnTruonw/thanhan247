<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ValidateExportExcelPay extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(auth()->guard('admin')->check()){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "start"  =>[
                "required",
                "date",
            ],
            "end"=>[
                "required",
                "date",
                "lte:start",
            ]
        ];
    }
    public function messages()
    {
        return [
            "start.required" => "Ngày bắt đầu là trường bắt buộc",
            "start.date" => "ngày bắt đầu phải là kiểu ngày",
            "end.required" => "Ngày kết thúc là trường bắt buộc",
            "end.date" => "ngày kết thúc phải là kiểu ngày",
            "end.lte" => "ngày kết thúc phải lớn hơn ngày bắt đầu",
        ];
    }
}
