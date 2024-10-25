<?php

namespace App\Future\PostResource;

use App\Future\PostResource\Modal\Base;
use App\Models\Post;
use Adminftr\Table\Future\BaseTable;
use Adminftr\Table\Future\Components\Actions\Action;
use Adminftr\Table\Future\Components\Actions\Actions;
use Adminftr\Table\Future\Components\Columns\TextColumn;
use Adminftr\Table\Future\Components\Filters\DateFilter;
use Adminftr\Table\Future\Components\Filters\SelectFilter;
use Adminftr\Table\Future\Components\Headers\Actions\ResetAction;
use Adminftr\Widgets\Future\Stat;
use App\Future\PostResource\View\Modal\Detail;


use Illuminate\Support\HtmlString;

class Table extends BaseTable
{
    protected string $model = Post::class;

    protected function columns(): array
    {
        return [
            TextColumn::make('id', __('ID'))->searchable()->sortable(),
            TextColumn::make('user_id', __('User id'))->searchable()->sortable(),
            TextColumn::make('created_at', __('Ngày tạo'))->sortable(),
            TextColumn::make('title', __('Tiêu đề'))->sortable(),
//            TextColumn::make('content', __('Nội dung bàn đăng'))
//                ->description(function (Post $post) {
//                return new HtmlString("<p>{$post->field}</p><p>{$post->type}</p>");
//            }),
            TextColumn::make('content', __('Nội dung bàn đăng'))->searchable()->sortable()->description(function (Post $post) {
                return new HtmlString("<p>{$post->content}</p><p>Lĩnh vực: {$post->field}</p><p>Trạng thái: {$post->type}</p>");
            }),
            TextColumn::make('status', __('Trạng thái'))->badge(
                [
                    'published' => 'success',
                    'waiting' => 'warning',
                    'draft' => 'danger',
                ],
                [
                    'published' => __('Hoạt Động'),
                    'waiting' => __('Khoá'),
                    'draft' => __('Nháp'),
                ]
            )
        ];
    }

    protected function filters(): array
    {
        return [
            SelectFilter::make('type', __('Trạng thái bài viết'))->options([
                ['id' => 'seeking_manufacturer', 'label' => 'Tìm kiếm nhà sản xuất'],
                ['id' => 'contract_created', 'label' => 'Đã tạo hợp đồng'],
            ]),
            DateFilter::make('created_at', __('Ngày tạo')),
        ];
    }

    protected function actions(Actions $actions): Actions
    {
        return $actions->create(
            [
                // Action::make('updateStatus', __('Mở khoá'), 'fas fa-trash-alt')->confirm('Bạn có chắc chắn muốn mở khoá bài viết này không?','warning',function ($data) {
                //     $model = Post::find($data['id']);
                //     $model->status = 'published';
                //     $model->save();
                // }),
                //view detail
                Action::make('view', __('Xem chi tiết'), 'fas fa-eye')->modal(Detail::class),
            ]
        );
    }

    protected function headerActions(): array
    {
        return [
            ResetAction::make(),
            // \Future\Table\Future\Components\Headers\Actions\Action::make('create', __('Tạo mới bài viết'))
            //     ->modal('create', Base::class),
        ];
    }

    protected function widgets(): array
    {
        $count = $this->model::query()->count();
        $countPost = Stat::make('Tổng số bài viết', $count);

        return [
            $countPost,
        ];
    }
}
