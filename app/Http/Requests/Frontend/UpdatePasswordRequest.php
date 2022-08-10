<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'current_password'      => 'required',
            'password'              => 'required|min:6|',
            'password_confirmation' => 'required|same:password',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'current_password.required' => 'Trường mật khẩu hiện tại là bắt buộc.',
            'current_password.required' => 'Trường mật khẩu là bắt buộc.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'password_confirmation.required' => 'Trường xác nhận mật khẩu là bắt buộc.',
            'password_confirmation.same' => 'Xác nhận mật khẩu và mật khẩu phải khớp.',
        
        ];
    }
}
