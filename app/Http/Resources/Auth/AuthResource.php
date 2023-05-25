<?php

namespace App\Http\Resources\Auth;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use JsonSerializable;

class AuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable|JsonResponse
     */
    public function toArray($request): array|Arrayable|JsonSerializable|JsonResponse
    {
        $response = [
            'meta' => [
                'success' => $this['success'],
                'errors' => $this['errors']
            ],
        ];
        if ($this['success']) {
            $response['data'] = [
                'token' => $this['token'] ?? null,
                'minutes_to_expire' => $this['minutes_to_expire'] ?? null
            ];
            return $response;
        }
        return response()->json($response, 401);
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function toResponse($request): JsonResponse
    {
        $response = $this->toArray($request);

        if (!$this['success']) {
            return $response;
        }

        return new JsonResponse($response);
    }
}
