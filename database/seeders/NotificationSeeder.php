<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Notifications\PostNotification;

class NotificationSeeder extends Seeder
{
    public function run()
    {
        // Lấy người dùng đầu tiên hoặc bất kỳ người dùng nào bạn muốn gửi thông báo
        $user = User::find(1);

        if ($user) {
            for ($i = 0; $i < 1000; $i++) {
                $user->notify(new PostNotification('post', 'abc', 'abc','1'));
            }
        }
    }
}
