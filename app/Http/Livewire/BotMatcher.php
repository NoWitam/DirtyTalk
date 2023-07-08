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
            return MatchResource::one(
                Bot::with('images')->whereDoesntHave('users', function (Builder $query) {
                    $query->where('users.id', Auth::id());
                })->inRandomOrder()->first()
            );
        });

        dump(storage_path('public/' . $this->bot['photos'][0]));
    }

    public function render()
    {
        return view('livewire.bot-matcher');
    }
}
