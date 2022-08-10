<?php

namespace App\Http\Requests\Admin\About;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class ValidateEditAbout extends FormRequest
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
            "name" => "required|min:1|max:191",
            "created_date" => "required|date",
            "to" => "required|min:3|max:191",
            "description" => "nullable",
            'admin_id'=>"required|exists:App\Models\Admin,id",
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
