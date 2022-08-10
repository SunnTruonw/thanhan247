<?php

namespace App\Http\Requests\Admin\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Role;
use App\Rules\ArrayValueExistDatabase;
class ValidateAddAdminUser extends FormRequest
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
        return [
            "name" => "required|min:3|max:250",
            "email" =>  [
                "required",
                Rule::unique("App\Models\Admin",'email')->where(function ($query) {
                    return $query->where([
                        ['deleted_at','=', null]
                    ]);
                })
            ],
            "password" =>"required",
            "password_confirmation"=>"required|same:password",
            "role_id"=>[
                "required",
                new ArrayValueExistDatabase(Role::all(),'id',request()->role_id)
            ],
            "active" => "required",
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
            "password.required" => "password is required",
            "password_confirmation.required" => "password_confirmation is required",
            "password_confirmation.same" => "password_confirmation is no same password",
            "active.required" => "active  is required",
            "checkrobot.accepted" => "checkrobot slider is accepted",
        ];
    }
}
