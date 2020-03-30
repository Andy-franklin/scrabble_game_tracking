<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GameRelationshipResource extends JsonResource
{
    public function toArray($request)
    {
        $members = [];
        foreach ($this->members as $member) {
            $members[] = new GameMemberRelationshipResource($member);
        }

        return [
            'members' => $members,
        ];
    }
}
