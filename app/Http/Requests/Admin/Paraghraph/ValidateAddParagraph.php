<?php

namespace App\Http\Requests\Admin\Paraghraph;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;
class ValidateAddParagraph extends FormRequest
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
            "orderParagraphAdd" => "nullable|numeric",
            "parentIdParagraphAdd" => "nullable|numeric",
            "image_path_paragraph_add.*" => "mimes:jpeg,jpg,png,svg,gif|nullable|file|max:3000",
            "activeParagraphAdd" => "required|numeric",
            "typeParagraphAdd" => "required",
        ];
        $langConfig = config('languages.supported');
        $langDefault = config('languages.default');
        foreach ($langConfig as $key => $value) {
            $arrConlai = $langConfig;
            unset($arrConlai[$key]);
            $keyConlai = array_keys($arrConlai);
            $keyConlai = collect($keyConlai);
            $rule['nameParagraphAdd_' . $key] = "required|min:1|max:191";
        }
        return $rule;
    }
    public function messages()
    {

    }

}
