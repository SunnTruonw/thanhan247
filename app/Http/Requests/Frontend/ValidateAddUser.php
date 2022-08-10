<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\NumberMin;
class ValidateAddUser extends FormRequest
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
            "name" => "required|min:3|max:250",
            // "email" =>  [
            //     "nullable",
            //     Rule::unique("App\Models\User",'email')->where(function ($query) {
            //         return $query->where([
            //             ['deleted_at','=', null]
            //         ]);
            //     })
            // ],
            "username" =>  [
                "required",
                Rule::unique("App\Models\User",'username')->where(function ($query) {
                    return $query->where([
                        ['deleted_at','=', null]
                    ]);
                })
            ],
            "masp"=>[
                "required",
                "min:3",
                "max:250",
                "exists:\App\Models\Product,masp",
            ],
            // "startpoint" =>[
            //     "required",
            //     new NumberMin(200)
            // ],
            // "password" =>"required",
            // "password_confirmation"=>"required|same:password",
            // "role_id"=>[
            //     "required",
            //     new ArrayValueExistDatabase(Role::all(),'id',request()->role_id)
            // ],
           // "active" => "required",
            "checkrobot" => "accepted"
        ];
    }
    public function messages()
    {
        return [
            "name.required" => "Name  is required",
            "name.min" => "Name  > 3",
            "name.max" => "Name  < 250",
            "email.required" => "email is required",
            "email.unique" => "email is exited",
            "username.required" => "username is required",
            "username.unique" => "username is exited",
            "password.required" => "password is required",
            "password_confirmation.required" => "password_confirmation is required",
            "password_confirmation.same" => "password_confirmation is no same password",
            "active.required" => "active  is required",
            "checkrobot.accepted" => "checkrobot slider is accepted",
            "masp.required" => "Mã sản phẩm là trường bắt buộc",
            "masp.min" => "ã sản phẩm  > 3",
            "masp.max" => "ã sản phẩm  <250",
            "masp.exists" => "Mã sản phẩm  không tồn tại",
        ];
    }
}
