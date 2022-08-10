<?php

namespace App\Http\Requests\Admin\Permission;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class ValidateAddPermission extends FormRequest
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
            "name"=>"required|min:3|max:100",
            "description"=>"required|min:3|max:100",
            "key_code" => [
                'nullable',
                Rule::unique("App\Models\Permission", 'key_code')->where(function ($query) {
                    return $query->where('deleted_at', null);
                })
            ],
            //"checkrobot" => "accepted",
        ];
    }

    public function messages()
    {
        return     [
            "name.required" => "name  is required",
            "name.min" => "name  is >3",
            "name.max" => "name  is <100",
            "description.required" => "description  is required",
            "description.min" => "description  is >3",
            "description.max" => "description  is <100",
            "key_code.unique" => "key_code đã tồn tại",
            "checkrobot.accepted" => "checkrobot  is accepted",
        ];
    }
}
