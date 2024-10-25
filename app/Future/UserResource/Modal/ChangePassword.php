<?php

namespace App\Future\UserResource\Modal;

use Adminftr\Form\Future\Components\Fields\TextInput;
use Adminftr\Form\Future\Components\Layouts\Row;
use Adminftr\Form\Future\ModalForm;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ChangePassword extends ModalForm
{
    protected $model = User::class;

    public function form(\Adminftr\Form\Future\Components\Form $form)
    {
        return $form->schema([
            Row::make($sm = 12, $md = 12, $lg = 12)->schema([
                TextInput::make('password')->required()->password()->label('Mật khẩu')->placeholder('Password'),
            ]),
        ]);
    }

    protected function beforeSave($data)
    {
        $data['password'] =  Hash::make($data['password']);

        return $data;
    }

    public function rules()
    {
        return [
            'data.password' => 'required',
        ];
    }
}
