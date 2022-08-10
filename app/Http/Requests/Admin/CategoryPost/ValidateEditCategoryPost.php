<?php

namespace App\Http\Requests\Admin\CategoryPost;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ValidateEditCategoryPost extends FormRequest
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
            "order" => "nullable|numeric",
            "avatar_path" => "mimes:jpeg,jpg,png,svg,gif|nullable|file|max:3000",
            "icon_path" => "mimes:jpeg,jpg,png,svg,gif|nullable|file|max:3000",
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
            $idPro = request()->route()->parameter('id');
            $pro = \App\Models\CategoryPost::find($idPro)->translationsLanguage($key)->first();
            $id = optional($pro)->id;
            $rule['name_' . $key] = "required|min:1|max:191";
            $rule['title_seo_'.$key]="nullable|max:1000";
            $rule['description_seo_'.$key]="nullable|max:1000";
            $rule['keyword_seo_'.$key]="nullable|max:1000";
            $rule['slug_' . $key] = [
                "required",
                'different:' . $stringKey,
                Rule::unique("App\Models\CategoryPostTranslation", 'slug')->ignore($id, 'id'),
            ];
        }
        return $rule;
    }

    public function messages()
    {
        return     [
            "name.required" => "Name category is required",
            "name.min" => "Name category > 3",
            "name.max" => "Name category < 100",
            "slug.required" => "slug category is required",
            "slug.unique" => "slug category đã tồn tại",
            "icon.mimes" => "icon category in jpeg,jpg,png,svg",
            "icon_path.max" => "icon category size < 3mb",
            "avatar.mimes" => "avatar category in jpeg,jpg,png,svg",
            "avatar_path.max" => "avatar category size < 3mb",
            "active.required" => "active category is required",
            "checkrobot.accepted" => "checkrobot category is accepted",
        ];
    }
}
