<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class PairResource extends CollectionResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'link' => route('matches', ['pair' => $this->id]),
            'name' => $this->bot->name,
            'avatar' => route('file', ['file' => $this->bot->images[0]]),
            'message' => [
                'text' => $this->lastMessage ? $this->lastMessage->text : '.',
                'isBot' => $this->lastMessage?->isBot
            ]
        ];
    }
}
