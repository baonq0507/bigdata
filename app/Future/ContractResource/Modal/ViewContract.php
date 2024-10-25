<?php

namespace App\Future\ContractResource\Modal;

use Adminftr\Form\Future\Components\Fields\Select;
use Adminftr\Form\Future\Components\Fields\TextInput;
use Adminftr\Form\Future\Components\Layouts\Row;
use Adminftr\Form\Future\ModalForm;
use App\Models\Contract;
use App\Models\Post;
class ViewContract extends ModalForm
{
    public $model = Contract::class;
    public bool $readOnly = true;
    public function form(\Adminftr\Form\Future\Components\Form $form)
    {
        return $form->schema([
            Row::make($sm = 12, $md = 6, $lg = 6)->schema([
                TextInput::make('code')
                    ->label('Mã HĐ')
                    ->placeholder('Mã HĐ')
                    ->readOnly(true),
                TextInput::make('post.field')
                    ->label('Lĩnh vực')
                    ->readOnly(true),
            ]),
        ]);
    }

    public function rules()
    {
        return [
            'data.name' => 'required',
            'data.guard_name' => 'required',
        ];
    }
}
