<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'phone' => ['required', 'numeric', 'regex:/^(0|(\+84))[3|5|7|8|9][0-9]{8}$/'],
            'token' => 'required|string',
            'password' => 'required|string|min:6'
        ];
    }

    public function messages()
    {
        return [
            'phone.required' => 'Số điện thoại là bắt buộc',
            'phone.numeric' => 'Số điện thoại phải là một số',
            'phone.regex' => 'Số điện thoại không hợp lệ',
            'token.required' => 'Token là bắt buộc',
            'password.required' => 'Mật khẩu là bắt buộc',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự'
        ];
    }
}
