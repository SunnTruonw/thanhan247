<?php

namespace App\Http\Requests\Admin\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\ArrayValueExistDatabase;
use App\Models\Role;
class ValidateEditAdminUser extends FormRequest
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
                    $id=request()->route()->parameter('id');
                    return $query->where([
                        ['deleted_at','=', null],
                        ['id','<>', $id],
                    ]);
                })
            ],
            "password" =>"",
            "password_confirmation"=>"same:password",
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
            "password_confirmation.same" => "password_confirmation is no same password",
            "active.required" => "active  is required",
            "checkrobot.accepted" => "checkrobot slider is accepted",
        ];
    }
}
