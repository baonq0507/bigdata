<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserConversation extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'conversation_id', 'date_joined', 'last_seen_message_id'];
    // Set the primary key to an array of columns
    protected $primaryKey = ['user_id', 'conversation_id'];

    // Disable incrementing
    public $incrementing = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function lastSeenMessage()
    {
        return $this->belongsTo(Message::class, 'last_seen_message_id');
    }

    // Override the getKeyForSaveQuery method
    protected function getKeyForSaveQuery()
    {
        $keys = [];

        foreach ($this->getKeyName() as $key) {
            if (! isset($this->$key)) {
                throw new Exception(__METHOD__.'Missing part of the primary key: '.$key);
            }

            $keys[$key] = $this->$key;
        }

        return $keys;
    }

    // Override the setKeysForSaveQuery method
    protected function setKeysForSaveQuery($query)
    {
        $keys = $this->getKeyForSaveQuery();

        foreach ($keys as $keyName => $keyValue) {
            $query->where($keyName, '=', $keyValue);
        }

        return $query;
    }
}
