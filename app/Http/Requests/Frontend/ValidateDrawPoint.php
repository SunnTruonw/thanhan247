<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\DrawPoint;
class ValidateDrawPoint extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(auth()->guard('web')->check()){
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
            "pay"=>[
                "required",
                'integer',
                new DrawPoint(),
            ],

            "checkrobot"=>"accepted"
        ];
    }
    public function messages()
    {
        return [
            "pay.required"=>"Số điểm là trường bắt buộc",
            "pay.integer"=>"Số điểm phải là số nguyên",
        ];
    }
}
