<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class MembersResource extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => MemberResource::collection($this->collection),
        ];
    }

    public function with($request)
    {
        return [
            'links'    => [
                'self' => route('member.index'),
            ],
        ];
    }
}
