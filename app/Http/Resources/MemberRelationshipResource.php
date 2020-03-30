<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MemberRelationshipResource extends JsonResource
{
    public function toArray($request)
    {
        $games = [];
        foreach ($this->games as $game) {
            $games[] = new MemberGameRelationshipResource($game);
        }

        return [
            'games' => $games,
            'bestGame' => (new MemberGameRelationshipResource($this->bestMatch())),
        ];
    }
}
