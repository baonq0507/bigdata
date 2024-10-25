<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => ['required', 'numeric', 'unique:users', 'regex:/^(0|(\+84))[3|5|7|8|9][0-9]{8}$/'],
            'password' => 'required|string|min:6',
            'confirm_password' => 'required|string|same:password',
            'address' => 'required|string',
            'type' => 'required|string|in:buyer,seller',
            'field' => 'required_if:type,seller|string|in:leather_goods,clothing',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên',
            'name.max' => 'Tên không được vượt quá 255 ký tự',
            'phone.required' => 'Vui lòng nhập số diện thoại',
            'phone.numeric' => 'Số diện thoại chỉ chứa các chữ số',
            'phone.unique' => 'Số diện thoại đã tồn tại',
            'phone.regex' => 'Số diện thoại không hợp lệ',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu phải ít nhất 6 ký tự',
            'confirm_password.required' => 'Vui lòng xác nhận mật khẩu',
            'confirm_password.same' => 'Xác nhận mật khẩu không trùng khớp',
            'address.required' => 'Vui lòng nhập địa chỉ',
            'type.required' => 'Vui lòng chọn loại người dùng',
            'type.in' => 'Loại người dùng không hợp lệ',
            'field.required_if' => 'Vui lòng nhập ngành hàng tương ứng',
            'field.in' => 'Ngành hàng không hợp lệ',
        ];
    }
}