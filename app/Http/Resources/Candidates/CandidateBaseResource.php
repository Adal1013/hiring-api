<?php

namespace App\Http\Resources\Candidates;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class CandidateBaseResource extends JsonResource
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
            'name' => $this->name,
            'source' => $this->source,
            'owner' => $this->owner,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'created_by' => $this->created_by
        ];
    }
}
