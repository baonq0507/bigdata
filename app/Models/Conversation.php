<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conversation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['type', 'name'];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_conversations');
    }
    public function lastMessage()
    {
        return $this->hasOne(Message::class)->latest();
    }

    public function lastSeenMessage()
    {
        return $this->hasOne(UserConversation::class)->where('user_id', auth()->id());
    }

    public function userConversations()
    {
        return $this->hasMany(UserConversation::class);
    }

    public function last_message_id()
    {
        return $this->hasOne(Message::class)->latest()->select('id');
    }
}
