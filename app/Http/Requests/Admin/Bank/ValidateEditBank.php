<?php

namespace App\Http\Requests\Admin\Bank;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class ValidateEditBank extends FormRequest
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
            "name" => [
                "required",
                "min:3",
                "max:100",
                Rule::unique("App\Models\Bank", 'name')->where(function ($query) {
                    $id=request()->route()->parameter('id');
                    return $query->where([
                        ['deleted_at', null],
                        ['id','<>',$id],
                    ]);
                })
            ],
            "active" => "required",
            "checkrobot" => "accepted",
        ];
    }
    public function messages()
    {
        return     [
            "name.required" => "Name  is required",
            "name.min" => "Name  > 3",
            "name.max" => "Name  < 100",
            "name.unique" => "Name đã tồn tại",
            "active.required" => "active  is required",
            "checkrobot.accepted" => "checkrobot  is accepted",
        ];
    }
}
