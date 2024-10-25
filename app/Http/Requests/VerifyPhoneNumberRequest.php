<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VerifyPhoneNumberRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'phone' => ['required', 'numeric', 'regex:/^(0|(\+84))[3|5|7|8|9][0-9]{8}$/'],
            'verification_code' => 'required|string'
        ];
    }

    public function messages()
    {
        return [
            'phone.required' => 'Số điện thoại là bắt buộc',
            'phone.numeric' => 'Số điện thoại phải là một số',
            'phone.regex' => 'Số điện thoại không hợp lệ',
            'verification_code.required' => 'Mã xác minh là bắt buộc'
        ];
    }
}
