<?php

namespace App\Http\Resources\Candidates;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use JsonSerializable;

class CandidateCollectionResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|Arrayable|JsonSerializable
    {
         return [
            'meta' => [
                'success' => true,
                'errors' => []
            ],
            'data' => CandidateBaseResource::collection($this->collection)
        ];
    }
}
