<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'phone' => ['required', 'numeric', 'regex:/^(0|(\+84))[3|5|7|8|9][0-9]{8}$/','exists:users'],
            'password' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'phone.required' => 'Vui lòng nhập số điện thoại',
            'phone.numeric' => 'Số diện thoại chỉ chứa các chữ số',
            'phone.regex' => 'Số diện thoại không hợp lệ',
            'phone.exists' => 'Số diện thoại không tồn tại trong hệ thống',
            'password.required' => 'Vui lòng nhập mật khẩu',
        ];
    }
}
