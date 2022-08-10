<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\ArrayValueExistDatabase;
use App\Models\Role;
class ValidateEditUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (auth()->guard('web')->check()) {
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
        $id=request()->route()->parameter('id');

            $rules= [
                "name" => "required|min:3|max:250",
                "email" =>  [
                    "email",
                    // Rule::unique("App\Models\User",'email')->where(function ($query) {
                    //     $id=request()->route()->parameter('id');
                    //     return $query->where([
                    //         ['deleted_at','=', null],
                    //         ['id','<>', $id],
                    //     ]);
                    // })
                    "nullable"
                ],
                "username" =>  [
                    "required",
                    Rule::unique("App\Models\User",'username')->where(function ($query) {
                        $id=request()->route()->parameter('id');
                        return $query->where([
                            ['deleted_at','=', null],
                            ['id','<>', $id],
                        ]);
                    })
                ],
                "avatar_path"=>"mimes:jpeg,jpg,png,svg|nullable",
                "password" =>"min:6|nullable",
                "password_confirmation"=>"same:password",

                "phone" => "nullable|min:10|max:11",
                'date_birth'=>"date:'d-m-Y'|nullable",
                "address"=>"nullable",
                //"hktt"=>"required",
                // "cmt"=>[
                //     "required",
                //     Rule::unique("App\Models\User",'cmt')->where(function ($query) {
                //         $id=request()->route()->parameter('id');
                //         return $query->where([
                //             ['deleted_at','=', null],
                //             ['id','<>', $id],
                //         ]);
                //     })
                // ],
              //  "ctk"=>"required|min:3|max:250",
               // "stk"=>"required|min:3|max:250",
               // "bank_id"=>'required|exists:App\Models\Bank,id',
                //"bank_branch" => "required|min:3|max:250",
                "sex" => "required|nullable",
              //  "active" => "required",
            ];

        return $rules;
    }
    public function messages()
    {
        return [
            "avatar_path.mimes"=>"Ảnh đại diện không đúng định dạng (jpeg,jpg,png,svg)",
            "name.required" => "Họ tên là trường bắt buộc",
            "name.min" => "Họ tên phải có độ dài 3",
            "name.max" => "Họ tên phải có độ dài 250",
            "email.required" => "email là trường bắt buộc",
            "email.unique" => "email đã tồn tại",
            "username.required" => "username là trường bắt buộc",
            "username.unique" => "username đã tồn tại",
            "cmt.required" => "CMT là trường bắt buộc",
            "cmt.unique" => "CMT đã tồn tại",
            "ctk.required" => "ctk là trường bắt buộc",
            "ctk.min" => "CTK phải có độ dài 3",
            "ctk.max" => "CTK phải có độ dài 250",

            "stk.required" => "STK là trường bắt buộc",
            "stk.min" => "STK phải có độ dài 3",
            "stk.max" => "STK phải có độ dài 250",

            "password.min"=>"password phải lớn hơn 6 ký tự",
            "password_confirmation.same" => "Password nhập không giống nhau",
            "phone.required" => "Số điện thoại là trường bắt buộc",
            "phone.min" => "Số điện thoại  không đúng định dạng",
            "phone.max" => "Số điện thoại  không đúng định dạng",

            "date_birth.date" => "Ngày sinh  không đúng định dạng",
            "address.required" => "Địa chỉ là trường bắt buộc",


            "bank_id.exists"=>"Ngân hàng là không hợp lệ",
            "bank_id.required"=>"Ngân hàng là trường bắt buộc",
            "bank_branch.required"=>"Chi nhánh ngân hàng là trường bắt buộc",
            "bank_branch.min" => "CNNH phải có độ dài 3",
            "bank_branch.max" => "CNNH phải có độ dài 250",

            "active.required" => "Active là trường bắt buộc",
            "checkrobot.accepted" => "Checkrobot  is accepted",
        ];
    }
}
