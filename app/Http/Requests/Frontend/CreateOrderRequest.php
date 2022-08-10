<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'customer_name' => 'required',
            'customer_phone' => 'required',
            'city' => 'required',
            'district' => 'required',
            'wards' => 'required',
            'customer_address' => 'required',
            'product_title' => 'required',
            'product_code' => 'required',
            'product_mass' => 'required|numeric',
            'product_qty' => 'required|numeric',
            'product_money' => 'required|numeric',
            'package_long' => 'numeric',
            'package_wide' => 'numeric',
            'package_high' => 'numeric',
        ];
    }

    /**
     * show the validation rules that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'customer_phone.required' => 'Trường số điện thoại không được để trống',
            'customer_name.required' => 'Trường họ tên không được để trống',
            'product_title.required' => 'Trường họ tên không được để trống',
            'city.required' => 'Trường thành phố không được để trống',
            'district.required' => 'Trường quận không được để trống',
            'wards.required' => 'Trường xã không được để trống',
            'customer_address.required' => 'Trường địa chỉ không được để trống',
            'product_title.required' => 'Trường tên sản phẩm không được để trống',
            'product_code.required' => 'Trường mã sản phẩm không được để trống',
            'product_mass.required' => 'Trường KL không được để trống',
            'product_mass.numeric' => 'Trường KL phải là số',
            'product_qty.required' => 'Trường số lượng sản phẩm không được để trống',
            'product_qty.numeric' => 'Trường số lượng sản phẩm phải là số',
            'product_money.required' => 'Trường số tiền sản phẩm không được để trống',
            'product_money.numeric' => 'Trường số tiền phải là số',
            'package_long.numeric' => 'Độ dài gói hàng phải là số',
            'package_wide.numeric' => 'Độ rộng gói hàng phải là số',
            'package_high.numeric' => 'Độ cao gói hàng phải là số',
        ];
    }
}
