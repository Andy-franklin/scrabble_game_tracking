<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MemberGameRelationshipResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'type' => 'game',
            'id' => (string)$this->id,
            'links' => [
                'show' => route('game.show', ['game' => $this->id]),
            ],
        ];
    }
}
