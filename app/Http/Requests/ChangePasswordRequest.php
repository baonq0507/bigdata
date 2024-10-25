<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:6'
        ];
    }

    public function messages()
    {
        return [
            'current_password.required' => 'Mật khẩu hiện tại là bắt buộc',
            'new_password.required' => 'Mật khẩu mới là bắt buộc',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự'
        ];
    }
}
