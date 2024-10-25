<?php

namespace App\Future\ContractResource;

use App\Models\Contract;
use Adminftr\Form\Future\BaseForm;
use Adminftr\Form\Future\Components\Fields\TextInput;
use Adminftr\Form\Future\Components\Layouts\Card;
use Adminftr\Form\Future\Components\Layouts\Row;
use Adminftr\Form\Future\Components\Fields\Select;
use App\Models\Post;
class Form extends BaseForm
{
    public $model = Contract::class;

    public function form(\Adminftr\Form\Future\Components\Form $form)
    {
        return $form->schema([
            Card::make()->schema([
                Row::make($sm=12,$md=6,$lg=6)->schema([
                    TextInput::make('code')->required()->label('Mã HĐ')->placeholder('Mã HĐ'),
                    Select::make('post')
                        ->required()
                        ->label('Lĩnh vực')
                        ->placeholder('Lĩnh vực')
                        ->relationship('post', 'field')
                        ->searchable(['field']),
                ])
            ])
        ]);
    }

    public function rules(){
        return [
            'data.code' => 'required',
            'data.post.field' => 'required',
        ];
    }
}
