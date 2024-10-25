<?php

namespace App\Future\ContractResource;

use Adminftr\Table\Future\BaseTable;
use Adminftr\Table\Future\Components\Actions\Action;
use Adminftr\Table\Future\Components\Actions\Actions;
use Adminftr\Table\Future\Components\Columns\TextColumn;
use Adminftr\Table\Future\Components\Filters\DateFilter;
use Adminftr\Table\Future\Components\Filters\SelectFilter;
use Adminftr\Table\Future\Components\Headers\Actions\ResetAction;
use Adminftr\Widgets\Future\Stat;
use App\Future\ContractResource\Modal\ViewContract;
use App\Models\Contract;
use Illuminate\Database\Eloquent\Builder;

class Table extends BaseTable
{
    protected string $model = Contract::class;
    public bool $canSelect = false;
    protected array $select = ['id_user_b','post_id'];
    protected function columns(): array
    {
        return [
            TextColumn::make('id', __('ID'))->searchable()->sortable(),
            TextColumn::make('code', __('Mã HĐ'))->searchable()->sortable(),
            TextColumn::make('post.field', __('Lĩnh vực'))->badge([
                'leather_goods' => 'success',
                'clothing' => 'primary'
            ], ['leather_goods' => __('Hàng hàng da'), 'clothing' => __('Quần áo'),
                'all' => __('Tất cả'),]),
            TextColumn::make('created_at', __('Ngày tạo'))->dateTime()->sortable(),
            TextColumn::make('user.name', __('Người tạo')),
            TextColumn::make('user.phone', __('SĐT'))->isRelation(),
            TextColumn::make('status', __('Trạng thái'))
                ->badge(
                    [
                        'new' => 'info', // Đợi xác nhận
                        'accepted' => 'success', // Đang sản xuất
                        'picking' => 'primary', // Đang gửi hàng
                        'failed_to_pick' => 'danger', // Không thể lấy hàng
                        'picked' => 'info', // Đã lấy hàng
                        'shipping' => 'primary', // Đang vận chuyển
                        'delivering' => 'primary', // Đã nhận hàng
                        'retry_delivery' => 'warning', // Giao hàng lại
                        'delivered_successfully' => 'success', // Hoàn thành
                        'pending' => 'warning', // Đợi thanh toán
                        'return_initiated' => 'warning', // Khiếu nại
                        'returned' => 'danger', // Hoàn tiền
                        'cancellation_requested' => 'danger', // Hủy
                        'return_in_progress' => 'warning', // Đang hoàn trả
                        'continue_delivery' => 'primary', // Tiếp tục giao hàng
                        'shop_cancellation' => 'danger', // Hủy bởi cửa hàng
                        'vtp_cancellation' => 'danger', // Hủy bởi vận chuyển viên
                    ],
                    [
                        'new' => __('Đợi xác nhận'), // Đợi xác nhận
                        'accepted' => __('Đang sản xuất'), // Đang sản xuất
                        'picking' => __('Đang gửi hàng'), // Đang gửi hàng
                        'failed_to_pick' => __('Không thể lấy hàng'), // Không thể lấy hàng
                        'picked' => __('Đã lấy hàng'), // Đã lấy hàng
                        'shipping' => __('Đang vận chuyển'), // Đang vận chuyển
                        'delivering' => __('Đã nhận hàng'), // Đã nhận hàng
                        'retry_delivery' => __('Giao hàng lại'), // Giao hàng lại
                        'delivered_successfully' => __('Hoàn thành'), // Hoàn thành
                        'pending' => __('Đợi thanh toán'), // Đợi thanh toán
                        'return_initiated' => __('Khiếu nại'), // Khiếu nại
                        'returned' => __('Hoàn tiền'), // Hoàn tiền
                        'cancellation_requested' => __('Hủy'), // Hủy
                        'return_in_progress' => __('Đang hoàn trả'), // Đang hoàn trả
                        'continue_delivery' => __('Tiếp tục giao hàng'), // Tiếp tục giao hàng
                        'shop_cancellation' => __('Hủy bởi cửa hàng'), // Hủy bởi cửa hàng
                        'vtp_cancellation' => __('Hủy bởi vận chuyển viên') // Hủy bởi vận chuyển viên
                    ]
                )
        ];

    }

    protected function filters(): array
    {
        return [SelectFilter::make('status', __('Trạng thái'))->options([['id' => 'accepted', 'label' => 'Hoàn Thành'], ['id' => 'pending', 'label' => 'Đợi khiếu nại'], ['id' => 'returned', 'label' => 'Hoàn lại tiền'], ['id' => 'cancel', 'label' => 'Huỷ'],]), DateFilter::make('created_at', __('Ngày tạo')),];
    }

    protected function actions(Actions $actions): Actions
    {
        return $actions->create(
            [
                Action::make('view', __('View'), 'fas fa-eye')->link(fn($data) => route('admin.contracts.view', $data->id)),
                // Action::make('edit', __('Edit'), 'fas fa-edit')->link(fn($data) => route('admin.contracts.edit', $data->id)),
            ]);
    }

    protected function headerActions(): array
    {
        return [ResetAction::make()];
    }

    protected function widgets(): array
    {
        $count = $this->model::query()->count();
        $countCancel = $this->model::query()->where('status', 'cancellation_requested')->count();
        $countSuccess = $this->model::query()->where('status', 'delivered_successfully')->count();
        $totalMoneySuccess = $this->model::query()->where('status', 'delivered_successfully')->sum('total_amount');
        return [Stat::make('Tổng số hợp đồng', $count)->description('Tổng số hợp đồng đã tạo'), Stat::make('Tổng số hợp đồng bị hủy', $countCancel)->description('Tổng số hợp đồng bị hủy'), Stat::make('Tổng số hợp đồng hoàn thành', $countSuccess)->description('Tổng số hợp đồng hoàn thành'), Stat::make('Tổng tiền hợp đồng hoàn thành', $totalMoneySuccess)->description('Tổng tiền hợp đồng hoàn thành'),];
    }

    protected function query(): Builder
    {
        return parent::query()->with(["user", "post"]); // TODO: Change the autogenerated stub
    }
}
