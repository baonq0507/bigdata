<?php

namespace Database\Seeders;
use App\Models\User;
use Adminftr\Messages\Http\Models\Conversation;
use Adminftr\Messages\Http\Models\Message;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class UserMessagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = DB::table('users')->where('id', '!=', 1)->get();

        foreach ($users as $user) {
            // Create a private conversation between user 1 and the other user
            $conversationId = DB::table('conversations')->insertGetId([
                'type' => 'private',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Add user 1 and the other user to the conversation
            DB::table('user_conversations')->insert([
                ['user_id' => 1, 'conversation_id' => $conversationId, 'date_joined' => now()],
                ['user_id' => $user->id, 'conversation_id' => $conversationId, 'date_joined' => now()],
            ]);

            // Create a message from user 1 in the conversation
            DB::table('messages')->insert([
                'conversation_id' => $conversationId,
                'sender_id' => 1,
                'content' => 'Hello, this is a seeded message.',
                'type' => 'text',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
