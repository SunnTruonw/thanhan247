<?php

namespace App\Http\Requests\Admin\CategoryExam;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ValidateAddCategoryExam extends FormRequest
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

            $rule['name_' . $key] = "required|min:1|max:191";
            $rule['title_seo_'.$key]="nullable|max:191";
            $rule['description_seo_'.$key]="nullable|max:191";
            $rule['keyword_seo_'.$key]="nullable|max:191";
            $rule['slug_' . $key] = [
                "required",
                'different:' . $stringKey,
                Rule::unique("App\Models\CategoryExamTranslation", 'slug'),
            ];
        }
        return $rule;
    }
    public function messages()
    {
        return     [
            "name.required" => "Name category is required",
            "name.min" => "Name category > 1",
            "name.max" => "Name category < 191",
            "slug.required" => "slug category is required",
            "slug.unique" => "slug đã tồn tại",
            "icon.mimes" => "icon category in jpeg,jpg,png,svg",
            "icon_path.max" => "icon category size < 3mb",
            "avatar.mimes" => "avatar category in jpeg,jpg,png,svg",
            "avatar_path.max" => "avatar category size < 3mb",
            "active.required" => "active category is required",
            "checkrobot.accepted" => "checkrobot category is accepted",
        ];
    }
}
