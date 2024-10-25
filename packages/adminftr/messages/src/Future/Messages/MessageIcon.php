<?php

namespace Adminftr\Messages\Future\Messages;

use Adminftr\Messages\Http\Models\Message;
use DB;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\On;
use Livewire\Component;

#[Lazy]
class MessageIcon extends Component
{
    public $count;

    public $userId;

    public $page = 10;

    public function mount()
    {
        $user = auth()->user();
        $this->count = $user->getUnreadMessages()->count();
        $this->userId = $user->id;
    }

    public function getListeners()
    {
        return [
            "echo-private:messages.{$this->userId},MessageSent" => 'refreshCount',
        ];
    }

    #[On('message-sent')]
    public function render()
    {
        $conversations = $this->getConversations();

        return view('messages::icon', compact('conversations'));
    }

    protected function getConversations()
    {
        $user = auth()->user();
        $lastMessageSub = Message::select('conversation_id', DB::raw('MAX(created_at) as last_message_at'))
            ->groupBy('conversation_id');

        $conversations = $user->conversations()
            ->joinSub($lastMessageSub, 'last_messages', function ($join) {
                $join->on('conversations.id', '=', 'last_messages.conversation_id');
            })
            ->with(['users' => function ($query) use ($user) {
                $query->where('id', '!=', $user->id);
            }, 'lastMessage'])
            ->orderBy('last_messages.last_message_at', 'desc')
            ->fastPaginate($this->page);

        return $conversations;
    }

    public function loadMore()
    {
        $this->page += 10;
    }

    protected function refreshCount()
    {
        $user = auth()->user();
        $this->count = $user->getUnreadMessages()->count();
    }
}
