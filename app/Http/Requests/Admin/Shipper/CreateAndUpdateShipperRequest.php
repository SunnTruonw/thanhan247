<?php

namespace App\Http\Requests\Admin\Shipper;

use Illuminate\Foundation\Http\FormRequest;

class CreateAndUpdateShipperRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email|unique:shippers',
            'phone' => 'required|numeric',
            'address' => 'required',
            'license_plates' => 'required|unique:shippers',
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
            'name.required' => 'Trường tên là bắt buộc.',
            'email.required' => 'Trường email là bắt buộc.',
            'email.unique' => 'Email đã tồn tại.',
            'phone.required' => 'Trường số điện thoại là bắt buộc.',
            'address.required' => 'Trường địa chỉ là bắt buộc.',
            'license_plates.required' => 'Trường biển số xe là bắt buộc.',
        ];
    }
}
