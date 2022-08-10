<?php

namespace App\Http\Requests\Admin\Exam;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class ValidateAddExam extends FormRequest
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
            "avatar_path"=>"mimes:jpeg,jpg,png,svg,gif|nullable|file|max:3000",
            "view"=>"nullable|integer",
            "time"=>"required|integer",
            "hot"=>"nullable|integer",
            "category_id"=>'exists:App\Models\CategoryExam,id',
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
           // dd($stringKey);
            // $leng=count($keyConlai);

            // array_map(function($k,$i){
            //     dd($i);
            // },$keyConlai);
            // dd($leng);
            // $defirent=implode("name_",$keyConlai);
            // dd($defirent);

            $rule['name_'.$key]="required|min:1|max:191";
            $rule['title_seo_'.$key]="nullable|max:191";
            $rule['description_seo_'.$key]="nullable|max:191";
            $rule['keyword_seo_'.$key]="nullable|max:191";
            $rule['slug_'.$key]=[
                "required",
                'different:'.$stringKey,
                Rule::unique("App\Models\ExamTranslation", 'slug'),
            ];
        }
        return $rule;


    }
    public function messages()
    {
        return [
            "name.required"=>"Name Exam is required",
            "name.min"=>"Name Exam > 1",
            "name.max"=>"Name Exam < 191",
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
