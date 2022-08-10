<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\NumberMin;
use App\Rules\NumberMax;
class ValidateTranferPointBetweenXY extends FormRequest
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
                "integer",
                'lte:end',
                new NumberMin(1),
                new NumberMax(\App\Models\User::max('order')),
            ],
            "end"  =>[
                "required",
                "integer",
                new NumberMin(1),
                new NumberMax(\App\Models\User::max('order')),
            ],
        ];
    }
    public function messages()
    {
        return [
            "start.required" => "start là trường bắt buộc",
            "start.integer" => "start phải là trường số",
            "start.lte" => "start phải <= end",
            "end.required" => "end là trường bắt buộc",
            "end.integer" => "end phải là trường số",
        ];
    }
}
