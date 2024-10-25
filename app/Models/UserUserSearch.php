<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserUserSearch extends Model
{
    protected $fillable = ['id','user_id', 'searched_user_id', 'searched_at'];

    // Quan hệ với người dùng thực hiện tìm kiếm
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Quan hệ với người dùng được tìm kiếm
    public function searchedUser()
    {
        return $this->belongsTo(User::class, 'searched_user_id');
    }
}
