<?php

namespace App\Restify;

use App\Models\UserUserSearch;
use Binaryk\LaravelRestify\Fields\BelongsTo;
use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;
use Illuminate\Support\Facades\Auth;

class UserUserSearchRepository extends Repository
{
    public static string $model = UserUserSearch::class;

    public static array $search = [
        'id',
        'user_id',
        'searched_user_id',
        'searched_at',
    ];

    public static array $sort = [
        'id',
        'user_id',
        'searched_user_id',
        'searched_at',
    ];


    public static array $match = [
        'id' => 'integer',
        'user_id' => 'integer',
        'searched_user_id' => 'integer',
        'searched_at' => 'datetime',
    ];

    public function fields(RestifyRequest $request): array
    {
        return [
            id(),
            field('user_id'),
            field('searched_user_id'),
            field('searched_at'),
            field('user'),
            field('searchedUser'),
        ];
    }

    public function index(RestifyRequest $request)
    {
        $request->merge(['user_id' => Auth::id()]);
        $query = parent::index($request);

        if ($query instanceof \Illuminate\Database\Eloquent\Builder) {
            $query->orderBy('searched_at', 'desc');
        }

        return $query;
    }

    public function store(RestifyRequest $request)
    {
        $request->merge(['user_id' => Auth::id()]);
        if ($request->user_id == $request->searched_user_id) {
            return response()->json(['message' => 'Không thể tìm kiếm chính mình'], 400);
        }
        if (UserUserSearch::where('user_id', $request->user_id)->where('searched_user_id', $request->searched_user_id)->exists()) {
            UserUserSearch::updateOrCreate([
                'user_id' => $request->user_id,
                'searched_user_id' => $request->searched_user_id,
            ], [
                'searched_at' => now(),
            ]);
            return response()->json(['message' => 'Đã cập nhật thời gian tìm kiếm'], 200);
        }
        return parent::store($request);
    }
}
