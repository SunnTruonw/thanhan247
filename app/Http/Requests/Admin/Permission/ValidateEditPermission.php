<?php

namespace App\Http\Requests\Admin\Permission;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class ValidateEditPermission extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (auth()->guard('admin')->check()) {
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
        return  [
            "name" => "required|min:3|max:100",
            "description" => "required|min:3|max:100",
            "key_code" =>            [
                "nullable",
                Rule::unique("App\Models\Permission", 'key_code')->where(function ($query) {
                    $id=request()->route()->parameter('id');
                    return $query->where([
                        ['deleted_at', null],
                        ['id','<>',$id],
                    ]);
                })
            ],

           // "checkrobot" => "accepted",
        ];
    }
    public function messages()
    {
        return     [
            "name.required" => "Name  is required",
            "name.min" => "Name  > 3",
            "name.max" => "Name  < 100",
            "description.required" => "description  is required",
            "description.min" => "description  > 3",
            "description.max" => "description  < 100",
            "key_code.unique" => "key_code đã tồn tại",
            "checkrobot.accepted" => "checkrobot  is accepted",
        ];
    }
}
