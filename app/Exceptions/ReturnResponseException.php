<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class ReturnResponseException extends Exception
{
    private $data;

    public function __construct($message = "", $code = 0, Throwable $previous = null, $data = [])
    {
        $this->data = $data;
        parent::__construct($message, $code, $previous);
    }

    public function report()
    {
    }

    public function render($request)
    {
        $response['error'] = [
            'message' => $this->getMessage(),
        ];

        if (!empty($this->data)) {
            $response['data'] = $this->data;
        }

        return response()->json($response, $this->getCode());
    }

    public function getData()
    {
        return $this->data;
    }
}
