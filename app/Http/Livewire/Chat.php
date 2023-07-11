<?php

namespace App\Http\Livewire;

use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Pagination\Cursor;

class Chat extends Component
{
    public $uuid;
    public $newMessage;
    public $messages;
    public $nextCursor;
    public $hasMorePages;

    protected $rules = [
        'newMessage' => 'required|max:255'
    ];

    public function getListeners()
    {
        return [
            "receive-message" => 'handleMessage',
        ];
    }

    public function mount($pair)
    {
        $this->newMessage = "";
        $this->uuid = $pair->id;
        $this->messages = [];
        $this->loadMessages();
    }

    public function handleMessage($message)
    {
        if($message['pair_id'] == $this->uuid) {
            array_unshift($this->messages, [
                'text' => $message['text'],
                'isBot' => $message['isBot']
            ]);
        }
    }

    public function loadMessages()
    {
        if ($this->hasMorePages !== null  && ! $this->hasMorePages) {
            return;
        }

        $messages = Message::where('pair_id', $this->uuid)
                                ->orderBy('created_at', 'desc')
                                ->cursorPaginate(25, ['*'], 'cursor', Cursor::fromEncoded($this->nextCursor));

        array_push($this->messages, ...$messages->toArray()['data']);

        if ($this->hasMorePages = $messages->hasMorePages()) {
            $this->nextCursor = $messages->nextCursor()->encode();
        }
    }

    public function send()
    {
        $this->validate();

        $message = Message::create([
            'pair_id' => $this->uuid,
            'text' => $this->newMessage,
            'isBot' => false
        ]);

        array_unshift($this->messages, ['text' => $this->newMessage, 'isBot' => false]);

        $this->emit('send-message', $message);

        $this->newMessage = "";
    }
    
    public function render()
    {
        return view('livewire.chat');
    }
}
