<?php

namespace App\Future\UserResource\Modal;

use Adminftr\Form\Future\Components\Fields\DateInput;
use Adminftr\Form\Future\Components\Fields\TextArea;
use Adminftr\Form\Future\Components\Fields\TextInput;
use Adminftr\Form\Future\Components\Layouts\Row;
use Adminftr\Form\Future\ModalForm;
use App\Models\User;
use packages\adminftr\form\src\Future\Components\Fields\Select;

class Form extends ModalForm
{
    protected $model = User::class;

    public function form(\Adminftr\Form\Future\Components\Form $form)
    {
        return $form->schema([
            Row::make($sm = 12, $md = 6, $lg = 6)->schema([
                TextInput::make('name')->required()->label('Tên')->placeholder('Name'),
                TextInput::make('email')->required()->label('Email')->placeholder('Email'),
                TextInput::make('password')->required()->password()->label('Mật khẩu')->placeholder('Password'),
                TextArea::make('address')->label('Địa chỉ')->placeholder('Address'),
                Select::make('gender')->label('Giới tính')->options([
                    'male' => 'nam',
                    'female' => 'nữ',
                    'non-binary' => 'không nhị phân',
                    'genderqueer' => 'giới tính lập dị',
                    'transgender' => 'chuyển giới',
                    'genderfluid' => 'giới tính linh hoạt',
                    'agender' => 'không giới tính',
                ]),
                DateInput::make('birthday')->label('Ngày sinh'),
            ]),
        ]);
    }

    public function rules()
    {
        return [
            'data.name' => 'required',
            'data.email' => 'required|email|unique:users,email',
            'data.password' => 'required',
        ];
    }

    protected function beforeSave($data) {}
}
