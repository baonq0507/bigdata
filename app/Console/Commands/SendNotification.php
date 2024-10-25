<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Notifications\UserNotification;

class SendNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a notification to a user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $userId = 1;

        $user = User::findOrFail($userId);
        $notification = new UserNotification($userId, 'Tiêu đề thông báo', 'Nội dung thông báo');
        for($i = 0; $i < 1; $i++) {
            $user->notify($notification);
        }
        $this->info('Notification sent successfully.');

        return 0;
    }
}
