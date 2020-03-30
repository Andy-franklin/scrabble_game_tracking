<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'type' => 'member',
            'id' => (string)$this->id,
            'attributes' => [
                'name' => $this->name,
                'bio' => $this->bio,
                'email' => $this->email,
                'phone' => $this->phone_number,
                'wins' => (string)$this->getWins(),
                'losses' => (string)$this->getLosses(),
                'average_score' => $this->averageScore(),
                'created_at' => $this->created_at
            ],
            'relationships' => new MemberRelationshipResource($this),
        ];
    }
}
