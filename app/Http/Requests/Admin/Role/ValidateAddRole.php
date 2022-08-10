<?php

namespace App\Http\Requests\Admin\Role;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\ArrayValueExistDatabase;
use App\Models\Permission;
class ValidateAddRole extends FormRequest
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
            "name" => [
                "required",
                "min:3",
                "max:250",
                Rule::unique("App\Models\Role", 'name')->where(function ($query) {
                    return $query->where('deleted_at', null);
                })
            ],
            "description" => "required|min:3|max:250",
            "permission_id"=>[
                "required",
                new ArrayValueExistDatabase(Permission::all(),'id',request()->permission_id)
            ],
            "checkrobot" => "accepted"
        ];
    }
    public function messages()
    {
        return [
            "name.required" => "Name  is required",
            "name.min" => "Name  > 3",
            "name.max" => "Name  < 250",
            "name.unique"=>"name đã tồn tại",
            "description.required" => "description  is required",
            "description.min" => "description  > 3",
            "description.max" => "description  < 250",
            "permission_id.required"=>"permission_id is required",
            "checkrobot.accepted" => "checkrobot role is accepted",
        ];
    }
}
