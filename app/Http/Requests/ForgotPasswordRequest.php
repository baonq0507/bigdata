<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    public function rules()
    {
        return [
            'phone' => ['required', 'numeric', 'regex:/^(0|(\+84))[3|5|7|8|9][0-9]{8}$/']
        ];
    }

    public function messages()
    {
        return [
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.numeric' => 'Số điện thoại phải chứa các chữ số.',
            'phone.regex' => 'Số điện thoại không hợp lệ.',
        ];
    }
}
