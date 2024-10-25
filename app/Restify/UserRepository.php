<?php

namespace App\Restify;

use App\Models\User;
use Binaryk\LaravelRestify\Fields\BelongsToMany;
use Binaryk\LaravelRestify\Fields\HasMany;
use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;

class UserRepository extends Repository
{
    public static string $model = User::class;
    public static array $search = ['name','email','phone','address'];
    public static int $globalSearchResults = 10;
    public static array $match = [
        'name'=>'string',
        'email'=>'string',
        'phone'=>'string',
        'address'=>'string',
        'birthday'=>'date',
        'gender'=>'string',
        'status'=>'string',
        'created_at'=>'between',
    ];

    public static function indexQuery(RestifyRequest $request, \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation $query)
    {
        $query->where('status', 'active');

        return parent::indexQuery($request, $query);
    }

    public function fields(RestifyRequest $request): array
    {
        return [
            field('name')->rules('required'),

            field('email')->storingRules('required', 'unique:users')->messages([
                'required' => 'Trường này là bắt buộc.',
            ]),

            field('avatar')->storingRules('required')->messages([
                'required' =>    'Trường này là bắt buộc.',
            ]),

            field('delivery_id'),
            field('phone')->rules('required', 'unique:users', 'phone')->messages([
                'required' => 'Trường này là bắt buộc.',
                'unique' => 'Trường này phải là duy nhất.',
                'phone' => 'Trường này là số điện thoại.',
            ]),

            field('address')->rules('required')->messages([
                'required' => 'Trường này là bắt buộc.',
            ]),

            field('store_name')->rules('required')->messages([
                'required' => 'Trường này là bắt buộc.',
            ]),

            field('birthday')->rules('required', 'date')->messages([
                'required' => 'Trường này là bắt buộc.',
                'date' => 'Trường này là ngày tháng.',
            ]),

            field('type')->rules('required', 'in:buyer,seller')->messages([
                'required' => 'Trường này là bắt buộc.',
                'in' => 'Trường này phải nằm trong danh sách cho trước.',
            ]),

            field('gender')
                ->rules('required', 'in:male,female,non-binary,genderqueer,transgender,genderfluid,agender')
                ->messages([
                'required' => 'Trường này là bắt buộc.',
                'in' => 'Trường này phải nằm trong danh sách cho trước.',
            ]),

            field('status')->rules('required', 'in:active,inactive,blocked')->messages([
                'required' => 'Trường này là bắt buộc.',
                'in' => 'Trường này phải nằm trong danh sách cho trước.',
            ]),
        ];
    }

    public static function related(): array
    {
        return [
            HasMany::make('posts'),
            HasMany::make('comments'),
            BelongsToMany::make('conversations'),
            HasMany::make('messages'),
        ];
    }
}
