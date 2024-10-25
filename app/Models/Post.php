<?php

namespace App\Models;

use App\Models\Comment;
use App\Models\PostImage;
use App\Models\TrafficPost;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    const FIELD = ['leather_goods', 'clothing','all'];
    const TYPE = ['seeking_manufacturer', 'contract_created'];
    const STATUS = ['draft','published','waiting'];

    protected $fillable = [
        'user_id', 'title', 'content', 'field', 'type', 'status'
    ];

    protected $casts = [
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function trafficPosts()
    {
        return $this->hasMany(TrafficPost::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->latest()->limit(2);
    }

    public function likes()
    {
        return $this->hasMany(TrafficPost::class)->where('type', 'like');
    }

    public function shares()
    {
        return $this->hasMany(TrafficPost::class)->where('type', 'share');
    }

    public function views()
    {
        return $this->hasMany(TrafficPost::class)->where('type', 'view');
    }

    public function images()
    {
        return $this->hasMany(PostImage::class);
    }

    public function listComments()
    {
        return $this->hasMany(Comment::class);
    }
}
