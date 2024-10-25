<?php

namespace App\Future\PermissionResource;

use Adminftr\Table\Future\BaseTable;
use Adminftr\Table\Future\Components\Actions\Action;
use Adminftr\Table\Future\Components\Actions\Actions;
use Adminftr\Table\Future\Components\Columns\TextColumn;
use Adminftr\Table\Future\Components\FilterInput;
use Adminftr\Table\Future\Components\Filters\Filter;
use Adminftr\Table\Future\Components\Filters\TextFilter;
use Adminftr\Table\Future\Components\Headers\Actions\ResetAction;
use Adminftr\Widgets\Future\Stat;
use App\Future\PermissionResource\Modal\Form;
use Spatie\Permission\Models\Permission;

class Table extends BaseTable
{
    protected string $model = Permission::class;

    protected function columns(): array
    {
        return [
            TextColumn::make('id', __('ID'))->searchable()->sortable(),
            TextColumn::make('name', __('permission_name'))->searchable()->sortable(),
            TextColumn::make('guard_name', __('Guard Name'))->searchable()->sortable(),
            TextColumn::make('created_at', __('Created At'))->sortable(),
            TextColumn::make('updated_at', __('Updated At'))->sortable(),
        ];
    }

    protected function filters(): array
    {
        return [
            TextFilter::make('name',__('permission_name'))
        ];
    }

    protected function actions(Actions $actions)
    {
        return $actions->create([Action::make('edit', __('edit'), 'fas fa-edit')->modal(Form::class), Action::make('delete', __('delete'), 'fas fa-trash-alt')->confirm('Xóa', function ($data) {
                $name = $data->name;

                return "Bạn có chắc chắn muốn xóa permission {$name} không?";
            }, function ($model) {
                $model->delete();
                $this->dispatch('swalSuccess', ['message' => 'Xóa thành công']);
            }),]);
    }

    protected function headerActions(): array
    {
        return [
            ResetAction::make(),
            \Adminftr\Table\Future\Components\Headers\Actions\Action::make('create', __('Create Permission'))->modal('create', Form::class)
        ];
    }

    protected function widgets()
    {
        $totalPermissions = Permission::count();
        $totalWebPermissions = Permission::where('guard_name', 'web')->count();
        $totalApiPermissions = Permission::where('guard_name', 'api')->count();
        return [Stat::make('Total Permissions', $totalPermissions), Stat::make('Total Web Permissions', $totalWebPermissions), Stat::make('Total Api Permissions', $totalApiPermissions),];
    }
}
