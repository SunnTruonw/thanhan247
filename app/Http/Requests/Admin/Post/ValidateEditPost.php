<?php

namespace App\Http\Requests\Admin\Post;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class ValidateEditPost extends FormRequest
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
            "hot"=>"nullable|integer",
            "category_id"=>'exists:App\Models\CategoryPost,id',
          //  "active"=>"required",
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

            $idPost=request()->route()->parameter('id');
            $post=\App\Models\Post::find($idPost)->translationsLanguage($key)->first();
            $id=optional($post)->id;

            // $rule['name_'.$key]="required|min:1|max:191";
            // $rule['slug_'.$key]=[
            //     "required",
            //     'different:'.$stringKey,
            //     Rule::unique("App\Models\PostTranslation", 'slug')->ignore($id, 'id'),
            // ];

            if($key==$langDefault){
                $rule['name_'.$langDefault]="required|min:1|max:191";
                $rule['slug_'.$langDefault]=[
                    "required",
                    'different:'.$stringKey,
                    Rule::unique("App\Models\PostTranslation", 'slug')->ignore($id, 'id'),
                ];
            }else{
                $rule['name_'.$key]="nullable|min:1|max:191";
                $rule['slug_'.$key]=[
                    "nullable",
                    'different:'.$stringKey,
                    Rule::unique("App\Models\PostTranslation", 'slug')->ignore($id, 'id'),
                ];
            }



            $rule['title_seo_'.$key]="nullable|max:1000";
            $rule['description_seo_'.$key]="nullable|max:1000";
            $rule['keyword_seo_'.$key]="nullable|max:1000";
        }
        return $rule;
    }

    public function messages()
    {
        return [
            "name.required"=>"Name post is required",
            "name.min"=>"Name post > 1",
            "name.max"=>"Name post < 191",
            "slug.required"=>"slug post is required",
            "slug.unique"=>"slug post is exits",
            "hot.integer"=>"hot is integer",
            "view.integer"=>"view is integer",
            "avatar.mimes"=>"avatar  in jpeg,jpg,png,svg",
            "active.required"=>"active  is required",
            "category_id"=>"category_id k tồn tại",
        ];
    }
}
