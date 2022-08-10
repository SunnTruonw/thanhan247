<?php

namespace App\Http\Requests\Admin\Supplier;

use Illuminate\Foundation\Http\FormRequest;

class ValidateEditSupplier extends FormRequest
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
            "email" => "string|email|max:255|nullable",
            "phone" => "nullable|max:255",
            "fax" => "nullable|max:255",
            "website" => "nullable|max:255",
            "logo_path"=>"mimes:jpeg,jpg,png,svg|nullable|file|max:3000",
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
        }
        return $rule;
    }
    public function messages()
    {
        return [
            "name.required" => "Name slide is required",
            "name.min" => "Name  > 3",
            "name.max" => "Name  < 250",
            "slug.required" => "slug slider is required",
            "image_path.mimes" => "image  in jpeg,jpg,png,svg",
            "active.required" => "active  is required",
            "checkrobot.accepted" => "checkrobot category is accepted",
        ];
    }
}
