<?php

namespace App\Http\Resources;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CollectionResource extends JsonResource
{
    public static function many(iterable $items)
    {
        return static::collection($items)->toArray(request());
    }

    public static function one(Model $item)
    {
        $class = get_called_class();
        return (new $class($item))->toArray(request());
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
