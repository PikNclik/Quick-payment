<?php

namespace App\Http\Controllers;

use App\Common\SharedMessages\ApiSharedMessage;
use Illuminate\Http\JsonResponse;
use App\Traits\ResponseAPI;

class BaseController extends Controller
{
    use ResponseAPI;

    /**
     * Handle manager messages.
     * @param ApiSharedMessage $message
     * @return JsonResponse
     */
    protected function handleSharedMessage(ApiSharedMessage $message): JsonResponse
    {
        // Check on message status.
        if ($message->status) {
            // Return success response.
            return $this->success(
                $message->data,
                $message->message,
                $message->statusCode ?? JsonResponse::HTTP_OK
            );
        }

        // Handle error of this message.
        return $this->error(
            [$message->message],
            $message->message,
            $message->statusCode ?? JsonResponse::HTTP_BAD_REQUEST
        );
    }
}
