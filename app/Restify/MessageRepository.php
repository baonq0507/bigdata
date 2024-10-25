<?php

namespace App\Restify;

use App\Events\UserPrivateMessageEvent;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Binaryk\LaravelRestify\Fields\BelongsTo;
use Binaryk\LaravelRestify\Fields\HasMany;
use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Auth;


class MessageRepository extends Repository
{

    public static string $model = Message::class;
    public static int $defaultPerPage = 20;
    public static array $search = [
        'id',
        'content',
        'conversation_id',
    ];

    public static array $sort = [
        'id',
        'content',
        'sender_id',
        'created_at',
        'updated_at',
    ];

    public static array $match = [
        'id' => 'integer',
        'sender_id' => 'integer',
        'content' => 'string',
        'conversation_id' => 'integer',
    ];

    public static int $globalSearchResults = 10;

    public function index(RestifyRequest $request)
    {
        $userId = $request->user_id;
        $authId = Auth::id();
        if($userId && $userId != $authId && $request->conversation_id == null) {
            $conversation = Conversation::whereHas('users', function (Builder $query) use ($userId, $authId) {
                $query->whereIn('user_id', [$userId, $authId]);
            })->where(function($query) use ($userId, $authId) {
                $query->whereHas('users', function (Builder $query) use ($userId) {
                    $query->where('user_id', $userId);
                })->whereHas('users', function (Builder $query) use ($authId) {
                    $query->where('user_id', $authId);
                });
            })->first();
            $request->merge(['conversation_id' => optional($conversation)->id]);
        }
        if (!Auth::user()->hasConversation($request->conversation_id)) {
            return response()->json(['message' => 'You are not allowed to access this conversation',
                'data' => []], 200);
        }

        return parent::index($request);
    }

    public function store(RestifyRequest $request)
    {
        try {
            if ($request->conversation_id == null && $request->user_id != null) {
                $user = User::find($request->user_id);
                $request->merge(['user' => $user]);

                if ($request->user_id == Auth::id()) {
                    return response()->json(['message' => 'You cannot send message to yourself'], 403);
                }
                $conversation = Conversation::whereHas('users', function (Builder $query) use ($request) {
                    $query->where('user_id', $request->user_id);
                })->whereHas('users', function (Builder $query) {
                    $query->where('user_id', Auth::id());
                })->first();
                if ($conversation) {
                    $request->merge(['conversation_id' => $conversation->id]);
                    $request->request->remove('user_id');
                }
                else{
                    $conversation = Conversation::create(['type' => 'private']);
                    $conversation->users()->attach(Auth::id());
                    $request->merge(['conversation_id' => $conversation->id]);
                    $conversation->users()->attach($request->user_id);
                    $request->request->remove('user_id');
                }
            }
            if (Auth::user()->hasConversation($request->conversation_id)) {

                if ($request->type == 'images') {
                    $files = $request->file('attachment_url');
                    $attachmentUrls = [];
                    foreach ($files as $file) {
                        $path = $file->store('public/messages');
                        $attachmentUrls[] = str_replace('public/', 'storage/', $path);
                    }
                    $request->merge(['attachment_url' => json_encode($attachmentUrls)]);
                }
                $request->merge(['sender_id' => Auth::id()]);

                return parent::store($request);
            }
            return response()->json(['message' => 'You are not allowed to access this conversation'], 403);
        }
        catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    public static function stored($resource, RestifyRequest $request)
    {
        $sender = Auth::user();
        if(!$request->user->is_active){
            sendFirebaseNotification(
                (string)$request->user->phone_token,
                'bạn có tin nhắn mới',
                'Push notification Dina app',
                ['type' => 'message', 'id_notice'=> "$resource->id.$resource->conversation_id",
                    'id' => (string)$resource->conversation_id]
            );
        }
        event(new \App\Events\UserMessageEvent($request->user, $resource, $sender));
    }

    public function fields(RestifyRequest $request): array
    {
        return [
            id(),
            field('conversation_id'),
            field('sender_id'),
            field('reply_to_id'),
            field('content')->rules('required'),
            field('type')->rules('required'),
            field('attachment_url'),
            field('created_at'),
            field('updated_at'),
        ];
    }

    public static function related(): array
    {
        return [
            'sender' => BelongsTo::make('sender', UserRepository::class),
        ];
    }
}
