<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ResponseAPI
{
    /**
     * Core of response
     *
     * @param string $message
     * @param mixed $data
     * @param integer $statusCode
     * @param boolean $isSuccess
     * @param $errors
     * @return JsonResponse
     */
    private function coreResponse(string $message, $data, int $statusCode, $errors, bool $isSuccess = true): JsonResponse
    {
        // Check the params
        if (!$message && !$errors) return response()->json(['message' => 'Message is required'], 500);

        // Send the response
        if ($isSuccess)
            return response()->json([
                'message' => $message,
                'status' => true,
                'data' => $data,
                'status_code' => $statusCode
            ]);

        return response()->json([
            'message' => $message,
            'status' => false,
            'data' => null,
            'errors' => $errors,
            'status_code' => $statusCode
        ]);
    }

    /**
     * Send any success response
     *
     * @param $data
     * @param null $message
     * @param int $statusCode
     * @return JsonResponse
     */
    public function success($data, $message = null, int $statusCode = 200): JsonResponse
    {
        $message = $message ? $message : __('success.success');
        return $this->coreResponse($message, $data, $statusCode, [], true);
    }

    /**
     * Send any error response
     *
     * @param $messages
     * @param null $message
     * @param int $statusCode
     * @return JsonResponse
     */
    public function error($messages, $message = null, int $statusCode = 500): JsonResponse
    {
        $message = $message ? $message : __('errors.error');
        return $this->coreResponse($message, null, $statusCode, $messages, false);
    }

    /**
     * Send any exception response
     *
     * @param $messages
     * @param null $message
     * @param int $statusCode
     * @return JsonResponse
     */
    public function exception($messages, $message = null, int $statusCode = 500): JsonResponse
    {
        $message = $message ? $message : __('errors.general_error');
        return $this->coreResponse($message, null, $statusCode, $messages, false);
    }
}
