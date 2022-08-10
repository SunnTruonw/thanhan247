<?php

namespace App\Http\Requests\Admin\Attribute;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class ValidateEditAttribute extends FormRequest
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
        // return [
        //     "name" => [
        //         "required",
        //         "min:3",
        //         "max:100",
        //         Rule::unique("App\Models\Attribute", 'name')->where(function ($query) {
        //             $id=request()->route()->parameter('id');
        //             return $query->where([
        //                 ['deleted_at', null],
        //                 ['id','<>',$id],
        //             ]);
        //         })
        //     ],
        //     "slug" => [
        //         "required",
        //         Rule::unique("App\Models\Attribute", 'slug')->where(function ($query) {
        //             $id=request()->route()->parameter('id');
        //             return $query->where([
        //                 ['deleted_at', null],
        //                 ['id','<>',$id],
        //             ]);
        //         })
        //     ],
        //     "active" => "required",
        //     "checkrobot" => "accepted",
        // ];

        $rule=[
            "order"=>"nullable|numeric",
            "avatar_path"=>"mimes:jpeg,jpg,png,svg,gif|nullable|max:3000",
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
            $rule['name_'.$key]="required|min:1|max:250";
            $rule['value_'.$key]="nullable|min:1|max:250";
        }
        return $rule;
    }
    public function messages()
    {
        return     [
            "name.required" => "Name  is required",
            "name.min" => "Name  > 3",
            "name.max" => "Name  < 100",
            "name.unique" => "Name đã tồn tại",
            "slug.unique" => "Slug đã tồn tại",
            "active.required" => "active  is required",
            "checkrobot.accepted" => "checkrobot  is accepted",
        ];
    }
}
