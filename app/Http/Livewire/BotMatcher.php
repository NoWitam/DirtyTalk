<?php

namespace App\Http\Livewire;

use App\Http\Resources\MatchResource;
use App\Models\Bot;
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
            Auth::user()->matches()->attach($this->bot['id'], ['accept' => $accept]);
            Cache::forget('showed_match.' . Auth::id());
            $this->mount();
            $this->dispatchBrowserEvent('match', ['accept' => $accept]);
        }
    }

    public function render()
    {
        return view('livewire.bot-matcher');
    }
}
