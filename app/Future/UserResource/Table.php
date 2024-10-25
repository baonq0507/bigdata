<?php

namespace App\Future\UserResource;

use Adminftr\Table\Future\BaseTable;
use Adminftr\Table\Future\Components\Actions\Action;
use Adminftr\Table\Future\Components\Actions\Actions;
use Adminftr\Table\Future\Components\BulkActions\BulkAction;
use Adminftr\Table\Future\Components\Columns\ImageColumn;
use Adminftr\Table\Future\Components\Columns\TextColumn;
use Adminftr\Table\Future\Components\Filters\DateFilter;
use Adminftr\Table\Future\Components\Filters\SelectFilter;
use Adminftr\Table\Future\Components\Filters\TextFilter;
use Adminftr\Table\Future\Components\Headers\Actions\Action as HeaderAction;
use Adminftr\Table\Future\Components\Headers\Actions\ResetAction;
use Adminftr\Widgets\Future\Stat;
use Adminftr\Widgets\Future\Widgets\Widget;
use App\Future\UserResource\Modal\ChangePassword;
use App\Models\User;
use Illuminate\Support\HtmlString;

class Table extends BaseTable
{
    public string $title = 'User Management';
    protected string $model = User::class;
    protected array $select = ['phone', 'email'];
    protected array $searchable = ['name', 'email', 'phone'];

    protected function columns(): array
    {
        return [
            TextColumn::make('id', __('ID'))->searchable()->sortable(),
            ImageColumn::make('avatar', __('user_avatar')),
            TextColumn::make('name', __('user_name'))->searchable()->sortable()->description(function (User $user) {
                return new HtmlString("<p>{$user->phone}</p><p>{$user->email}</p>");
            }),
            TextColumn::make('birthday')->dateTime(),
            TextColumn::make('status', __('user_status'))->badge(
                [
                    'active' => 'success',
                    'inactive' => 'danger',
                ],
                [
                    'active' => __('active'),
                    'inactive' => __('inactive'),
                ]
            ),
            TextColumn::make('gender', __('gender'))->badge([
                'male' => 'primary',
                'female' => 'danger',
            ], [
                'male' => 'Nam',
                'female' => 'Nữ',
            ]),
            TextColumn::make('created_at', __('Created At'))->dateTime()->sortable(),
            TextColumn::make('updated_at', __('Updated At'))->dateTime()->sortable(),
        ];
    }

    protected function filters(): array
    {

        return [
            TextFilter::make('name', __('user_name'), 'like'),
            TextFilter::make('email', __('user_email')),
            TextFilter::make('phone', __('user_phone')),
            SelectFilter::make('status', __('user_status'))->options([
                ['id' => 'active', 'name' => 'active'],
                ['id' => 'inactive', 'name' => 'inactive'],
                ['id' => 'blocked', 'name' => 'blocked'],
            ]),
            SelectFilter::make('gender', __('user_gender'))->options(
                [
                    ['id' => 'male', 'name' => 'nam'],
                    ['id' => 'female', 'name' => 'nữ'],
                    ['id' => 'non-binary', 'name' => 'không nhị phân'],
                    ['id' => 'genderqueer', 'name' => 'giới tính lập dị'],
                    ['id' => 'transgender', 'name' => 'chuyển giới'],
                    ['id' => 'genderfluid', 'name' => 'giới tính linh hoạt'],
                    ['id' => 'agender', 'name' => 'không giới tính'],
                ]
            ),
            DateFilter::make('birthday', __('user_birthday')),
            DateFilter::make('created_at', __('user_created_at')),
            DateFilter::make('updated_at', __('user_updated_at')),
        ];
    }

    protected function actions(Actions $actions)
    {
        return $actions->create([
            Action::make('edit', __('edit'), 'fas fa-edit')->link(function ($data) {
                return route('admin.users.edit', $data->id);
            })->size('font-size:20px;'),
            Action::make('password', __('change password'), 'ti ti-key')
                ->modal(ChangePassword::class)->size('font-size:20px;'),
            Action::make('delete', __('delete'), 'fas fa-trash-alt')->confirm('Xóa', function ($data) {
                $name = $data->name;
                return 'Bạn có chắc chắn muốn xóa người dùng ' . $name . ' không?';
            }, function ($model) {
                $model->delete();
                $this->dispatch('swalSuccess', ['message' => 'Xóa thành công']);
            }),
        ]);
    }

    protected function headerActions(): array
    {
        return [
            ResetAction::make(),
            HeaderAction::make('create', __('future::messages.add_data'))
                ->to(route('admin.users.create')),
        ];
    }

    protected function bulkActions(): array
    {
        return [
            BulkAction::make(
                'deletes',
                __('deletes'),
                'fas fa-trash-alt',
                __('Are you sure you want to deletes User?')
            )
                ->callback(function ($data) {
                    User::destroy($data);
                }),
        ];
    }

    protected function widgets()
    {
        return [
            Stat::make(100,'demo')
        ];
    }
}
