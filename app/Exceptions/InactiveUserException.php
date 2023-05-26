<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class InactiveUserException extends Exception
{
    /**
     * @return JsonResponse
     */
    public function render(): JsonResponse
    {
        return response()->json(
            [
                "meta" => [
                    'success' => false,
                    'errors' => ['User is not active.']
                ]
            ],
            401
        );
    }
}
