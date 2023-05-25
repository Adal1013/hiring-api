<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class GeneralException extends Exception
{
    protected $message;
    protected $code;

    /**
     * @param $message
     * @param $code
     */
    public function __construct($message, $code)
    {
        parent::__construct();
        $this->message = $message;
        $this->code = $code;
    }

    /**
     * @return JsonResponse
     */
    public function render(): JsonResponse
    {
        return response()->json(
            [
                "meta" => [
                    'success' => false,
                    'errors' => $this->message
                ]
            ],
            $this->code
        );
    }
}
