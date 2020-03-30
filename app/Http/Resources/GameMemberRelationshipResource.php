<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GameMemberRelationshipResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'type' => 'member',
            'id' => (string)$this->id,
            'attributes' => [
                'name' => $this->name,
                'score' => $this->pivot->score
            ],
            'links' => [
                'show' => route('member.show', ['member' => $this->id]),
            ],
        ];
    }
}
