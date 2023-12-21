<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * DatabaseException
 */
class DatabaseException extends Exception
{
    /**
     * @var string
     */
    public string $errorMessage;

    /**
     * @param $message
     * @param $errorMessage
     */
    public function __construct($message, $errorMessage)
    {
        parent::__construct($message);
        $this->errorMessage = $errorMessage;
    }

    /**
     * @return JsonResponse
     */
    public function render(): JsonResponse
    {
        return response()->json([
            'message' => $this->message,
            'error' => config('app.env') != 'production' ? $this->errorMessage :  "",
            'success' => false
        ], Response::HTTP_BAD_REQUEST);
    }

}
