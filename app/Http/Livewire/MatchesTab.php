<?php

namespace App\Http\Livewire;

use App\Http\Resources\PairResource;
use App\Models\Pair;
use Illuminate\Pagination\Cursor;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MatchesTab extends Component
{
    public $pairs;
    public $nextCursor;
    public $hasMorePages;

    public function getListeners()
    {
        return [
            "echo-private:messages.". Auth::id() .",BotReplyReceived" => 'handleEchoMessage',
            'send-message' => 'handleMessage'
        ];
    }

    
    public function mount()
    {
        $this->pairs = [];
        $this->loadPairs();
    }

    public function loadPairs()
    {
        if ($this->hasMorePages !== null  && ! $this->hasMorePages) {
            return;
        }

        $pairs = Pair::with('bot.images')
                ->with('lastMessage')
                ->where('user_id', Auth::id())
                ->where('accept', 1)
                ->orderBy('updated_at', 'desc')
                ->cursorPaginate(8, ['*'], 'cursor', Cursor::fromEncoded($this->nextCursor));

        array_push($this->pairs, ...PairResource::many($pairs));

        if ($this->hasMorePages = $pairs->hasMorePages()) {
            $this->nextCursor = $pairs->nextCursor()->encode();
        }
    }

    public function handleEchoMessage($data) 
    {    
        $this->emit('receive-message', $data['message']);
        $this->handleMessage($data['message']);
    }

    public function handleMessage($message)
    {
        $index = array_search($message['pair_id'], array_column($this->pairs, 'id'));

        if($index !== false) {
            $pair = $this->pairs[$index];
            unset($this->pairs[$index]);
            $pair['message'] = [
                'text' => $message['text'],
                'isBot' => $message['isBot']
            ];
            array_unshift($this->pairs, $pair);
        } else {
            array_unshift($this->pairs, PairResource::one(Pair::with('bot.images')->with('lastMessage')->find($message['pair_id'])));
        }
    }

    public function render()
    {
        return view('livewire.matches-tab');
    }
}
