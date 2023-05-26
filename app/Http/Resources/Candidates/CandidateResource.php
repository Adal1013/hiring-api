<?php

namespace App\Http\Resources\Candidates;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class CandidateResource extends JsonResource
{
    protected int $statusCode;

    public function __construct($resource, $statusCode = 200)
    {
        parent::__construct($resource);
        $this->statusCode = $statusCode;
    }

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
            'data' => new CandidateBaseResource($this)
        ];
    }

    /**
     * @param $request
     * @param $response
     * @return void
     */
     public function withResponse($request, $response): void
    {
        $response->setStatusCode($this->statusCode);
    }
}
