<?php

namespace App\Common\SharedMessages;

/**
 * Class SharedMessage
 * @package App\Common
 */
class ApiSharedMessage
{
    public $statusCode;
    public $exception;
    public $message;
    public $status;
    public $data;

    /**
     * ApiSharedMessage constructor.
     * @param $message
     * @param $data
     * @param $status
     * @param $exception
     * @param $statusCode
     */
    public function __construct(
        $message,
        $data,
        $status,
        $exception,
        $statusCode
    )
    {
        $this->message = $message;
        $this->data = $data;
        $this->status = $status;
        $this->statusCode = $statusCode;
        $this->exception = $exception;
    }
}

