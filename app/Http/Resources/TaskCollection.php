<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TaskCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => TaskResource::collection($this->collection),
        ];
    }
}
