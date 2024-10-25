<?php

namespace App\Restify;

use App\Models\Product;
use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;
use Binaryk\LaravelRestify\Repositories\Repository;

class ProductRepository extends Repository
{
    public static string $model = Product::class;

    public static array $search = [
        'id',
        'field',
        'contract_id',
        'name',
        'color',
        'quantity',
        'price',
        'gender',
        'size',
        'material',
        'description',
    ];
    public static array $match = [
       'id'=>'int',
        'name'=>'string',
        'contract_id'=>'int',
    ];



    public function fields(RestifyRequest $request): array
    {
        return [
            id(),
            field('field')->rules('required')->storeBulkRules('required')->messages([
                'required' => 'Lĩnh vực không được để trống',
            ]),
            field('contract_id')->rules('required')->storeBulkRules('required')->messages([
                'required' => 'Contract ID không được để trống',
            ]),
            field('name')->rules('required')->storeBulkRules('required')->messages([
                'required' => 'Tên không được để trống',
            ]),
            field('color')->rules('required')->storeBulkRules('required')->messages([
                'required' => 'Màu sắc không được để trống',
            ]),
            field('quantity')->rules('required')->storeBulkRules('required')->messages([
                'required' => 'Số lượng không được để trống',
            ]),
            field('price')->rules('required')->storeBulkRules('required')->messages([
                'required' => 'Giá không được để trống',
            ]),
            field('gender')->rules('required')->storeBulkRules('required')->messages([
                'required' => 'Giới tính không được để trống',
            ]),
            field('size'),
            field('material')->rules('required')->storeBulkRules('required')->messages([
                'required' => 'Chất liệu không được để trống',
            ]),
            field('description'),
        ];
    }
}
