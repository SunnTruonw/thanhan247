<?php

namespace App\Http\Requests\Admin\Setting;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ValidateAddSetting extends FormRequest
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
        $rule=[
            "value" => "nullable",
            "order"=>"nullable|numeric",
            // "description"=>"required",
            "image_path"=>"mimes:jpeg,jpg,png,svg,gif|nullable|file|max:3000",
            "file"=>"mimes:pdf,rar|file|max:20480",
            "active" => "required",
            // "checkrobot" => "accepted"
        ];
        $langConfig=config('languages.supported');
        $langDefault=config('languages.default');

        foreach ($langConfig as $key => $value) {
            $arrConlai=$langConfig;
            unset($arrConlai[$key]);
            $keyConlai = array_keys($arrConlai);
            $keyConlai= collect($keyConlai);

            $stringKey = $keyConlai->map(function ($item, $key) {
                return "name_".$item;
            });
            $stringKey= $stringKey->implode(', ');
            $rule['name_'.$key]="required|min:3|max:250";
            $rule['slug_'.$key]="nullable|min:3|max:250";
        }
        return $rule;
    }
    public function messages()
    {
        return [
            "name.required" => "name  is required",
            "name.unique" => "name setting is exits",
            "name.min" => "name  > 3",
            "name.max" => "name  < 250",
            "slug.unique" => "slug setting is exits",
            "active.required" => "active  is required",
            "checkrobot.accepted" => "checkrobot  is accepted",
        ];
    }
}
