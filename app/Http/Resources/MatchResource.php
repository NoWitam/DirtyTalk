<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class MatchResource extends CollectionResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $photos = [];
        foreach($this->images as $image) 
        {
            $photos[] = route('file', ['file' => $image->id]);
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'age' => $this->birthday->age,
            'description' => $this->description,
            'photos' => $photos
        ];
    }
}
