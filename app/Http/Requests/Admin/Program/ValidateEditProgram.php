<?php

namespace App\Http\Requests\Admin\Program;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class ValidateEditProgram extends FormRequest
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
            "time"=>"nullable|numeric",
            "avatar_path"=>"mimes:jpeg,jpg,png,svg,gif|nullable|file|max:3000",
            "view"=>"nullable|integer",
            "hot"=>"nullable|integer",
            "category_id"=>'exists:App\Models\CategoryProgram,id',
            "active"=>"required",
        ];
        $langConfig=config('languages.supported');
        $langDefault=config('languages.default');

        foreach ($langConfig as $key => $value) {
            $arrConlai=$langConfig;
            unset($arrConlai[$key]);
            $keyConlai = array_keys($arrConlai);
            $keyConlai= collect($keyConlai);

            $stringKey = $keyConlai->map(function ($item, $key) {
                return "slug_".$item;
            });
            $stringKey= $stringKey->implode(', ');

            $idProgram=request()->route()->parameter('id');
            $program=\App\Models\Program::find($idProgram)->translationsLanguage($key)->first();
            $id=optional($program)->id;

            $rule['name_'.$key]="required|min:1|max:191";
            $rule['title_seo_'.$key]="nullable|max:191";
            $rule['description_seo_'.$key]="nullable|max:191";
            $rule['keyword_seo_'.$key]="nullable|max:191";
            $rule['slug_'.$key]=[
                "required",
                'different:'.$stringKey,
                Rule::unique("App\Models\ProgramTranslation", 'slug')->ignore($id, 'id'),
            ];
        }
        return $rule;
    }

    public function messages()
    {
        return [
            "name.required"=>"Name Program is required",
            "name.min"=>"Name Program > 1",
            "name.max"=>"Name Program < 191",
            "slug.required"=>"slug Program is required",
            "slug.unique"=>"slug Program is exits",
            "hot.integer"=>"hot is integer",
            "view.integer"=>"view is integer",
            "avatar.mimes"=>"avatar  in jpeg,jpg,png,svg",
            "active.required"=>"active  is required",
            "category_id"=>"category_id k tồn tại",
        ];
    }
}
