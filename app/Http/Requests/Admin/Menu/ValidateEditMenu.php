<?php

namespace App\Http\Requests\Admin\Menu;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class ValidateEditMenu extends FormRequest
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
        //         Rule::unique("App\Models\Menu", 'name')->where(function ($query) {
        //             $id=request()->route()->parameter('id');
        //             return $query->where([
        //                 ['deleted_at', null],
        //                 ['id','<>',$id],
        //             ]);
        //         })
        //     ],
        //     "slug" => [
        //         "required",
        //         Rule::unique("App\Models\Menu", 'slug')->where(function ($query) {
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
            $rule['name_'.$key]="required|min:1|max:191";
            $rule['slug_'.$key]="nullable|min:1|max:191";
        }
        return $rule;
    }
    public function messages()
    {
        return     [
            "name.required" => "Name  is required",
            "name.min" => "Name  > 1",
            "name.max" => "Name  < 191",
            "name.unique" => "Name đã tồn tại",
            "slug.unique" => "Slug đã tồn tại",
            "active.required" => "active  is required",
            "checkrobot.accepted" => "checkrobot  is accepted",
        ];
    }
}
