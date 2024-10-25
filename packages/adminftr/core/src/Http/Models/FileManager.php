<?php

namespace Adminftr\Core\Http\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileManager extends Model
{
    protected $fillable = [
        'file_name', 'file_path', 'user_id', 'file_type', 'file_size', 'description','folder_path', 'tags','folder_path'
    ];

    // Thiết lập mối quan hệ với model User (nếu cần)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
