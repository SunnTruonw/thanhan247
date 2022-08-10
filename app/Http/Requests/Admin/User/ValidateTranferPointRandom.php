<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\NumberMin;
use App\Rules\NumberMax;
use App\Rules\CheckKeyByOrder;
class ValidateTranferPointRandom extends FormRequest
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
            "order"  =>[
                "required",
                "integer",
                'exists:\App\Models\User,order',
                new NumberMin(1),

                new NumberMax(\App\Models\User::max('order')),
                new CheckKeyByOrder(),

            ],
            "point"=>[
                "required",
                "integer",
            ]
        ];
    }
    public function messages()
    {
        return [
            "order.required" => "STT là trường bắt buộc",
            "order.integer" => "STT phải là trường số nguyên",
            "order.exists"=>"STT không tồn tại",
            "point.required" => "Điểm là trường bắt buộc",
            "point.integer" => "Điểm phải là trường số nguyên",
        ];
    }
}
