<?php

namespace App\Restify;

use App\Models\Delivery;
use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;
use Binaryk\LaravelRestify\Fields\Field;
use Binaryk\LaravelRestify\Repositories\Repository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;

class DeliveryRepository extends Repository
{
    public static string $model = Delivery::class;
    public static int $globalSearchResults = 10;

    public static array $search = [
        'id',
        'name',
        'code',
        'contract_id',
        'product_note',
        'order_note',
        'order_service',
        'order_service_add',
        'status',
    ];

    public static array $match = [
        'id' => 'int',
        'name' => 'string',
        'code' => 'string',
        'contract_id' => 'int',
        'product_note' => 'string',
        'order_note' => 'string',
        'order_service' => 'string',
        'order_service_add' => 'string',
        'status' => 'string',
    ];
    public function fields(RestifyRequest $request): array
    {
        return [
            id(),
            field('name'),
            field('code'),
            field('contract_id'),
            field('package_image'),
            field('product_length'),
            field('product_width'),
            field('product_height'),
            field('product_weight'),
            field('product_note'),
            field('delivery_user_a_info'),
            field('delivery_user_b_info'),
            field('list_products'),
            field('money_total_ship'),
            field('order_note'),
            field('order_service'),
            field('order_service_add'),
            field('status'),
            field('created_at'),
            field('updated_at'),
        ];
    }


    public static function indexQuery(RestifyRequest $request, Relation|Builder $query)
    {
        $query->whereHas('contract', function($q) use ($request){
          $q->whereHas('partyAInfo', function($q) use ($request){
              $q->where('user_id', $request->user()->id);
          })->orWhereHas('partyBInfo', function($q) use ($request){
              $q->where('user_id', $request->user()->id);
          });
        });
        return parent::indexQuery($request, $query);

    }

    public static function related(): array
    {
        return [
            'userDeliveryInfo' => UserDeliveryInfoRepository::class,
        ];
    }
}
