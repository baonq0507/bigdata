<?php

namespace App\Restify;


use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Notifications\PostNotification;
use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;
use Illuminate\Support\Facades\Auth;


class CommentRepository extends Repository
{
    public static string $model = Comment::class;
    public static array $search = ['content'];
    public static array $sort = ['id','content','post_id','user_id','created_at','updated_at'];

	public static array $match = [
		'id'=>'string',
		'content'=>'string',
		'post_id'=>'string',
		'user_id'=>'string',
		'created_at'=>'between',
		];
    public static function indexQuery(RestifyRequest $request, Relation|Builder|\Illuminate\Database\Eloquent\Relations\Relation|\Illuminate\Database\Eloquent\Builder $query)
    {
        $query->whereHas('post', function ($query) {
            $query->where('status', 'published');
        });
        return parent::indexQuery($request, $query);
    }
    public function fields(RestifyRequest $request): array
    {
        return [
            id(),
            field('post_id')->rules( 'required','exists:posts,id')->messages([
                'required' => 'Bài viết không được để trống',
                'exists' => 'Bài viết không tồn tại',
            ]),

            field('user_id')->storeCallback(function ($value) {
                return auth()->user()->id;
            })->updateCallback(function ($value) {
                return auth()->user()->id;
            }),
            field('user.name')->label('user_name'),
            field('user.avatar')->label('user_avatar'),
            field('content')->rules('required')->messages([
                'required' => 'Nội dung không được để trống',
            ]),
            field('created_at'),
        ];
    }

    public static function stored($resource, RestifyRequest $request)
    {
        $post = Post::find($resource->post_id);
        $user = User::find($post->user_id);
        if($user->id != auth()->user()->id){
            $user->notify(new PostNotification('comment', $resource->content, 'có lượt comment',$post->id,auth()->user(),$resource->id));
            sendFirebaseNotification(
                (string)$user->phone_token,
                'bạn có comment',
                'Push notification Dina app',
                ['type' => 'comment', 'id_notice'=> "$resource->id.$resource->post_id",
                    'id' => (string)$resource->post_id]);

        }

    }
}
