<?php

namespace App\Http\Livewire;

use App\Http\Resources\MatchResource;
use App\Models\Bot;
use App\Models\Pair;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class BotMatcher extends Component
{
    public $bot;
    public function mount()
    {
        $this->bot = Cache::remember('showed_match.' . Auth::id(), 2 * 60 * 60, function () {
            $bot = Bot::with('images')->whereDoesntHave('users', function (Builder $query) {
                $query->where('users.id', Auth::id());
            })->inRandomOrder()->first();
            return $bot ? MatchResource::one($bot) : null;
        });
    }

    public function match(bool $accept)
    {
        if($this->bot) {
            $pair = Pair::create([
                'user_id' => Auth::id(),
                'bot_id' => $this->bot['id'],
                'accept' => $accept
            ]);
            $this->mount();
            $this->dispatchBrowserEvent('match', ['accept' => $accept]);
            if($accept) {
                return redirect()->route('matches', ['pair' => $pair]);
            }
        }
    }

    public function render()
    {
        return view('livewire.bot-matcher');
    }
}
