<?php

namespace Adminftr\Messages\Future\Messages;

use Adminftr\Messages\Http\Models\Message;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Messages extends Component
{
    use WithPagination;

    #[Url, Locked]
    public $conversationId;

    public $page = 10;

    public $message = '';

    public function mount($conversationId = null)
    {
        $this->conversationId = $conversationId;
    }

    #[On('changeConversation')]
    public function changeConversation($conversationId)
    {
        $this->conversationId = $conversationId;
        $this->page = 10;
    }

//    public function getListeners()
//    {
//        return [
//            "echo-private:messages.{$this->conversationId},MessageSent" => 'refreshMessages',
//        ];
//    }

    public function loadMore()
    {
        $this->page += 15;
    }

    public function render()
    {
        $user = null;
        $messages = [];

        if ($this->conversationId) {
            $conversation = auth()->user()->conversations()->findOrFail($this->conversationId);

            $user = $conversation->users()
                ->where('id', '!=', auth()->user()->id)
                ->first();

            $messages = $this->getMessages()
                ->when($conversation->exists(), function ($query) {
                    return $query->fastPaginate($this->page);
                });
        }

        return view('messages::messages', compact('messages', 'user'));
    }

    protected function getMessages()
    {
        return Message::with('sender')
            ->where('conversation_id', $this->conversationId)
            ->orderByDesc('created_at');
    }
}
