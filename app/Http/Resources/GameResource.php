<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'type' => 'game',
            'id' => (string)$this->id,
            'attributes' => [
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
            'relationships' => new GameRelationshipResource($this)
        ];
    }
}
