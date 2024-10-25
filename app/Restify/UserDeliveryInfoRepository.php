<?php

namespace App\Restify;

use App\Models\UserDeliveryInfo;
use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;

class UserDeliveryInfoRepository extends Repository
{
    public static string $model = UserDeliveryInfo::class;

    public static array $search = ['address', 'phone', 'receiver_name'];

    public static array $sort = ['id', 'address', 'phone', 'receiver_name', 'created_at', 'updated_at'];

    public static array $match = [
        'id' => 'integer',
        'user_id' => 'integer',
        'address' => 'string',
        'district_id' => 'integer',
        'province_id' => 'integer',
        'ward_id' => 'integer',
        'phone' => 'string',
        'receiver_name' => 'string',
        'created_at' => 'between',
        'updated_at' => 'between',
    ];

    public static function indexQuery(RestifyRequest $request, $query)
    {
        return $query->where('user_id', $request->user()->id);
    }

    public function fields(RestifyRequest $request): array
    {
        return [
            id(),
            field('user_id'),
            field('store_id')->canStore(function ($request) {
                return false;
            })->canUpdate(function ($request) {
                return false;
            }),
            field('address')->rules('required')->messages([
                'required' => 'Trường này là bắt buộc.',
            ]),
            field('district_id')->rules('required')->messages([
                'required' => 'Trường này là bắt buộc.',
            ]),
            field('province_id')->rules('required')->messages([
                'required' => 'Trường này là bắt buộc.',
            ]),
            field('ward_id')->rules('required')->messages([
                'required' => 'Trường này là bắt buộc.',
            ]),
            field('receiver_name')->rules('required')->messages([
                'required' => 'Trường này là bắt buộc.',
            ]),
            field('phone')->rules('required')->messages([
                'required' => 'Trường này là bắt buộc.',
            ]),
        ];
    }

    public function store(RestifyRequest $request)
    {
        if($request->user_id != $request->user()->id) {
            abort(403, 'Không thể thêm thông tin giao hàng cho người khác.');
        }

        return parent::store($request);
    }
}
