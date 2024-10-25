<?php

namespace App\Future\PostResource;

use App\Models\Post;
use App\Models\User;
use Adminftr\Form\Future\BaseForm;
use Adminftr\Form\Future\Components\Actions\Action;
use Future\Form\Future\Components\Fields\Select;
use Future\Form\Future\Components\Fields\TextArea;
use Future\Form\Future\Components\Fields\TextInput;
use Future\Form\Future\Components\Layouts\Card;
use Future\Form\Future\Components\Layouts\Col;
use Future\Form\Future\Components\Layouts\Row;

class Form extends BaseForm
{
    protected $model = Post::class;

    public function form(\Adminftr\Form\Future\Components\Form $form)
    {
        return $form->schema([
            Row::make()->schema([
                Col::make()->schema([
                    Card::make()->schema([
                        Row::make(12, 12, 6)->schema([
                            TextInput::make('title')->required()->label('Tiêu đề bài viết')->placeholder('Tiêu đề bài viết'),
                            Select::make('field')->label('Lĩnh vức')->options(
                                [
                                    ['id' => 'leather_goods', 'label' => 'Hàng đã khoá'],
                                    ['id' => 'clothing', 'label' => 'Quấn áo'],
                                    ['id' => 'all', 'label' => 'Tất cả'],
                                ]
                            )->required(),
                            Select::make('type')->label('Kiểu bài viết')->options(
                                [
                                    ['id' => 'seeking_manufacturer', 'label' => 'Tìm kiếm nhà sản xuất'],
                                    ['id' => 'contract_created', 'label' => 'Đã có hợp đồng']
                                ]
                            )->required(),
                            Select::make('status')->label('Trạng thái bài viết')->options(
                                [
                                    ['id' => 'draft', 'label' => 'Nháp'],
                                    ['id' => 'published', 'label' => 'Hoạt động'],
                                    ['id' => 'waiting', 'label' => 'Chờ'],
                                ]
                            )->required(),
                            Col::make()->schema([
                                TextArea::make('content')->required()->label('Nội dung bài viết')->placeholder('Nội dung bài viết'),
                            ])->col(12),
//                            Select::make('user_id')->label('UserId')->required()->liveSearch(
//                                function ($query) {
//                                    User::where('name', 'like', '%'.$query.'%')->limit(20)->get();
//                                }
//                            ),
                        ]),
                    ]),
                ]),
            ]),
        ]);
    }

    public function Actions()
    {
        return [
            Action::make('saveAndClose', 'Lưu và đóng')->color('primary'),
            Action::make('cancel', 'Hủy')->color('danger'),
        ];
    }
}
