<?php

namespace App\Models;

use Adminftr\Messages\Http\Models\Traits\HasMessages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens,HasRoles;
    use HasRoles;
    use HasMessages;
    protected $fillable = [
        'name', 'email', 'phone', 'avatar', 'address', 'birthday', 'gender', 'password','is_active',
        'status', 'field', 'type','store_name','phone_token','phone_verified_at','email_verified_at','delivery_id'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $dates = ['last_login_at', 'updated_at', 'created_at','birthday'];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function trafficPosts()
    {
        return $this->hasMany(TrafficPost::class);
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

    public function postsImages()
    {
        return $this->hasMany(PostImage::class);
    }
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function messageReactions()
    {
        return $this->hasMany(MessageReaction::class);
    }

    public function userConversations()
    {
        return $this->hasMany(UserConversation::class);
    }

    public function conversations()
    {
        return $this->belongsToMany(Conversation::class, 'user_conversations');
    }

    public function hasConversation($conversation_id)
    {
        return $this->conversations()->where('id', $conversation_id)->exists();
    }

    public function UserDeliveryInfo()
    {
        return $this->hasMany(UserDeliveryInfo::class);
    }


}
