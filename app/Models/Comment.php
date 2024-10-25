<?php

namespace App\Models;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Post\Database\factories\CommentFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id', 'user_id', 'content', 'status'
    ];

    protected $casts = [
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
