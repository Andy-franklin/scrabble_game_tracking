<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class GamesResource extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => GameResource::collection($this->collection),
        ];
    }

    public function with($request)
    {
        return [
            'links'    => [
                'self' => route('game.index'),
            ],
        ];
    }
}
