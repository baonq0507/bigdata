<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditProfileRequest extends FormRequest
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
            'name' => 'string|max:255',
            'avatar' => 'image|mimes:jpg,jpeg,png,gif,svg|max:2048',
            'address' => 'string',
            'birthday' => 'date',
            'type' => 'string',
            'status' => 'string',
            'gender' => ['string', Rule::in(['male','female','non-binary','genderqueer','transgender','genderfluid','agender'])]
        ];
    }

    public function messages()
    {
        return [
            'name.max' => 'Tên không được vượt quá 255 ký tự',
            'avatar.mimes' => 'Ảnh đại diện phải là một trong các định dạng: jpg, jpeg, png, gif, svg',
            'avatar.image' => 'Ảnh đại diện phải là một hình ảnh',
            'avatar.max' => 'Dung lượng ảnh đại diện không được quá 2048KB',
            'birthday.date' => 'Ngày sinh phải là một ngày hợp lệ',
            'gender.in' => 'Giới tính phải là một trong các giá trị: male, female, non-binary, genderqueer, transgender, genderfluid, agender',
        ];
    }
}
