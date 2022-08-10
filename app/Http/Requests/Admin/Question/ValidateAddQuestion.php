<?php

namespace App\Http\Requests\Admin\Question;

use Illuminate\Foundation\Http\FormRequest;

class ValidateAddQuestion extends FormRequest
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
        $rule=[
            "order"=>"nullable|numeric",
            "type"=>"nullable|integer",
            "exam_id"=>'exists:App\Models\Exam,id',
            "active"=>"required|numeric",
        ];
        $langConfig=config('languages.supported');
        $langDefault=config('languages.default');

        foreach ($langConfig as $key => $value) {
            $rule['name_'.$key]="required|min:1";
        }
        return $rule;
    }
    public function messages()
    {
        return [
            "name.required"=>"Name Exam is required",
            "name.min"=>"Name Exam > 3",
            "name.max"=>"Name Exam < 250",
            "slug.required"=>"slug Exam is required",
            "slug.unique"=>"slug Exam is exits",
            "hot.integer"=>"hot is integer",
            "view.integer"=>"view is integer",
            "avatar.mimes"=>"avatar  in jpeg,jpg,png,svg",
            "active.required"=>"active  is required",
            "category_id"=>"category_id k tồn tại",

        ];
    }
}
