<?php

namespace App\Http\Livewire;

use App\Http\Resources\BotResource;
use App\Models\Bot;
use Livewire\Component;
use Livewire\WithFileUploads;

class BotTable extends Component
{
    use WithFileUploads;
    public $bots;
    public $newBot;

    protected $rules = [
        'newBot.name' => 'required|min:5|max:20',
        'newBot.description' => 'required|max:250',
        'newBot.birthday' => 'required|date',
        'newBot.image.*' => 'image|max:102400'
    ];

    public function mount()
    {
        $this->newBot = [];
        $this->bots = BotResource::many(Bot::withCount('images')->get());
    }

    public function create()
    {
        $this->validate();
      
        $bot = Bot::create([
            'name' => $this->newBot['name'],
            'description' => $this->newBot['description'],
            'birthday' => $this->newBot['birthday'],
        ]);

        if(isset($this->newBot['image'])) {
            $images = [];
            foreach($this->newBot['image'] as $image)
            {
                $images[] = ['path' => $image->store('bots')];
            }
            $bot->images()->createMany($images);
        }

        $this->mount();
    }

    public function delete($id)
    {
        Bot::destroy($id);
        $this->mount();
    }
    public function render()
    {
        return view('livewire.bot-table')
            ->extends('layouts.admin');
    }
}
