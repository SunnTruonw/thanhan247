<?php

namespace App\Http\Requests\Admin\Program;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ValidateAddProgram extends FormRequest
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


        $rule = [
            "time"=>"nullable|numeric",
            "order" => "nullable|numeric",
            "avatar_path" => "mimes:jpeg,jpg,png,svg,gif|nullable|file|max:3000",
            "view" => "nullable|integer",
            "hot" => "nullable|integer",
            "category_id" => 'exists:App\Models\CategoryProgram,id',
            "active" => "required",
        ];
        $langConfig = config('languages.supported');
        $langDefault = config('languages.default');

        foreach ($langConfig as $key => $value) {
            $arrConlai = $langConfig;
            unset($arrConlai[$key]);
            $keyConlai = array_keys($arrConlai);
            $keyConlai = collect($keyConlai);
            $stringKey = $keyConlai->map(function ($item, $key) {
                return "slug_" . $item;
            });
            $stringKey = $stringKey->implode(', ');
            // dd($stringKey);
            // $leng=count($keyConlai);

            // array_map(function($k,$i){
            //     dd($i);
            // },$keyConlai);
            // dd($leng);
            // $defirent=implode("name_",$keyConlai);
            // dd($defirent);

            $rule['name_' . $key] = "required|min:1|max:191";
            $rule['title_seo_'.$key]="nullable|max:191";
            $rule['description_seo_'.$key]="nullable|max:191";
            $rule['keyword_seo_'.$key]="nullable|max:191";
            $rule['slug_' . $key] = [
                "required",
                'different:' . $stringKey,
                Rule::unique("App\Models\ProgramTranslation", 'slug'),
            ];
        }

        $rule['typeParagraph.*']='required';
        $typeParagraph = request()->input('typeParagraph') ?? [];

        foreach ($typeParagraph as $keyP => $valueP) {
        //    $rule['typeParagraph' . $value['value'] . '.' . $keyP] = 'required';
            foreach ($langConfig as $key => $value) {
                $nameParagraph = request()->input('nameParagraph_' . $value['value']) ?? [];
                foreach ($nameParagraph as $keyP2 => $value2) {
                    $rule['nameParagraph_' . $value['value'] . '.' . $keyP] = 'required';
                }
            }
        }
        //  dd($rule);
        return $rule;
    }
    public function messages()
    {
        return [
            "name.required" => "Name post is required",
            "name.min" => "Name post > 1",
            "name.max" => "Name post < 191",
            "slug.required" => "slug post is required",
            "slug.unique" => "slug post is exits",
            "hot.integer" => "hot is integer",
            "view.integer" => "view is integer",
            "avatar.mimes" => "avatar  in jpeg,jpg,png,svg",
            "active.required" => "active  is required",
            "category_id" => "category_id k tồn tại",

        ];
    }
}
