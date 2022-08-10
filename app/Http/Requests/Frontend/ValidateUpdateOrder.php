<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\DrawPoint;
use App\Rules\PointLessTotalValueProduct;
class ValidateUpdateOrder extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (auth()->guard('web')->check()) {
            return true;
        } else {
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
            "usePoint" => [
                'nullable',
                "integer",
              //  new DrawPoint(),
             //   new PointLessTotalValueProduct(),
            ],
            "name"=>"required|min:3|max:255",
            "phone"=>'required|regex:/[0-9]{10,11}/',
            "city_id"=>'required|exists:App\Models\City,id',
            "district_id"=>'required|exists:App\Models\District,id',
            "commune_id"=>'required|exists:App\Models\Commune,id',
        ];
    }
    public function messages()
    {
        return [
            "usePoint.integer"=>"Điểm phải là kiểu số nguyên",
            "name.required" => "Tên là trường bắt buộc",
            "name.min" => "Tên  > 3",
            "name.max" => "Tên  < 250",
            "email.required" => "email is trường bắt buộc",
            "phone.required" => "Số điện thoại là trường bắt buộc",
            "phone.regex" => "Số điện thoại là không đúng định dạng",
            "city_id.required" => "Thành phố là trường bắt buộc",
            "city_id.exists" => "Thành phố là không tồn tại",
            "district_id.required" => "quận huyện là trường bắt buộc",
            "district_id.exists" => "quận huyện là không tồn tại",
            "commune_id.required" => "phường, xã là trường bắt buộc",
            "commune_id.exists" => "phường, xã  là không tồn tại",
        ];
    }
}
