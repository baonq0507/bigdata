<?php

namespace App\Restify;

use App\Models\UserConversation;
use Binaryk\LaravelRestify\Fields\BelongsTo;
use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;


class UserConversationRepository extends Repository
{
    public static string $model = UserConversation::class;
    public static function indexQuery(RestifyRequest $request, $query)
    {
        return $query->where('user_id', $request->user()->id);
    }

    public static array $search = [
        'id',
    ];

    public static array $sort = [
        'id',
        'user_id',
        'conversation_id',
        'date_joined',
        'last_read_at',
    ];

    public function fields(RestifyRequest $request): array
    {
        return [
            field('user_id')->rules('required', 'exists:users,id')->messages([
                'required' => 'Trường này là bắt buộc.',
                'exists' => 'Trường này đã tồn tại.',
            ]),
            field('conversation_id')->rules('required', 'exists:conversations,id')->messages([
                'required' => 'Trường này là bắt buộc.',
                'exists' => 'Trường này đã tồn tại.',
            ]),
            field('date_joined')->rules('required')->messages([
                'required' => 'Trường này là bắt buộc.',
            ]),
            field('last_seen_message_id'),
        ];
    }

    public static function related(): array
    {
        return [
            'user' => BelongsTo::make('user', UserRepository::class),
            'conversation' => BelongsTo::make('conversation', ConversationRepository::class),
            'lastSeenMessage' => BelongsTo::make('lastSeenMessage', MessageRepository::class),
        ];
    }
}
