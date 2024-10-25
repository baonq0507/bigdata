<?php

namespace App\Restify;

use App\Models\TrafficPost;
use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;

class TrafficPostRepository extends Repository
{
    public static string $model = TrafficPost::class;

    public static array $search = ['post_id', 'user_id'];
    public static int $globalSearchResults = 10;
    public static array $match = [
        'post_id' => 'string',
        'user_id' => 'string',
    ];

    public function fields(RestifyRequest $request): array
    {
        return [
            id(),
            field('post_id')->rules('required', 'exists:posts,id')->messages([
                'required' => 'Bài viết không được để trống',
                'exists' => 'Bài viết không tồn tại',
            ]),
            field('ip')->storeCallback(function ($value) {
                return request()->ip();
            })->updateCallback(function ($value) {
                return request()->ip();
            }),
            field('user_id')->storeCallback(function ($value) {
                return auth()->user()->id;
            })->updateCallback(function ($value) {
                return auth()->user()->id;
            }),
            field('type')->rules('required', 'in:like,share')->messages([
                'required' => 'Loại không được để trống',
                'in' => 'Loại không hợp lệ',
            ]),

        ];
    }
}
