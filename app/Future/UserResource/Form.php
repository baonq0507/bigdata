<?php

namespace App\Future\UserResource;

use Adminftr\Form\Future\BaseForm;
use Adminftr\Form\Future\Components\Fields\DateInput;
use Adminftr\Form\Future\Components\Fields\Radio;
use Adminftr\Form\Future\Components\Fields\Select;
use Adminftr\Form\Future\Components\Fields\TextInput;
use Adminftr\Form\Future\Components\Fields\Upload;
use Adminftr\Form\Future\Components\Layouts\Card;
use Adminftr\Form\Future\Components\Layouts\Col;
use Adminftr\Form\Future\Components\Layouts\Row;
use App\Models\User;
use Spatie\Permission\Models\Role;

class Form extends BaseForm
{
    protected $model = User::class;

    public function form(\Adminftr\Form\Future\Components\Form $form)
    {
        return $form->schema([
            Row::make()->schema([
                Col::make()->schema([
                    Card::make()->schema([
                        Row::make(12, 6, 6)->schema([
                            TextInput::make('name')
                                ->label('Tên')
                                ->rules('required, max:255, min:3')
                                ->messages([
                                    'required' => 'Tên không được để trống',
                                    'max' => 'Tên không được quá 255 ký tự',
                                    'min' => 'Tên không được dưới 3 ký tự',
                                ])
                                ->placeholder('Name'),
                            TextInput::make('email')->required()->label('Email')->placeholder('Email'),
                            TextInput::make('password')->required()->password()->label('Mật khẩu')
                                ->placeholder('Password')->canUpdate(false),
                            TextInput::make('store_name')->required()->label('Tên cửa hàng')->placeholder('Tên cửa hàng'),
                            DateInput::make('birthday')->label('Ngày sinh'),
                            TextInput::make('phone')->label('Số điện thoại')->placeholder('Phone')
                                ->rules('required, max:10, min:10')->messages(
                                    [
                                        'required' => 'Số điện thoại không được để trống',
                                        'max' => 'Số điện thoại không được quá 10 số',
                                        'min' => 'Số điện thoại không được dưới 10 số',
                                    ]
                                ),

                        ]),
                    ]),
                ])->sm(12)->md(6)->lg(8),
                Col::make()->schema([
                    Card::make()->schema([
                        Row::make()->schema([
                            Select::make('roles')->label('Vai trò')->relationship(
                                'roles',
                                'name'
                            )->multiple(),
                            Select::make('gender')->label('Giới tính')->options(
                                [
                                    ['id' => 'male', 'name' => 'nam'],
                                    ['id' => 'female', 'name' => 'nữ'],
                                    ['id' => 'non-binary', 'name' => 'không nhị phân'],
                                    ['id' => 'genderqueer', 'name' => 'giới tính lập dị'],
                                    ['id' => 'transgender', 'name' => 'chuyển giới'],
                                    ['id' => 'genderfluid', 'name' => 'giới tính linh hoạt'],
                                    ['id' => 'agender', 'name' => 'không giới tính'],
                                ]
                            )->required(),
                            Radio::make('status')->label('Trạng thái')->options([['value' => 'active', 'label' => 'Hoạt động'], ['value' => 'inactive', 'label' => 'Không hoạt động']])->required(),
                            Upload::make('avatar')->label('Ảnh đại diện')->storeAs('public', 'avatar', 'public')->multiple()->maxFiles(4),
                        ]),
                    ]),
                ])->sm(12)->md(6)->lg(4),
            ]),
        ]);
    }
}
