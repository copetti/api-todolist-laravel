<?php

namespace App\Exceptions;

use Exception;

class LoginInvalidException extends Exception
{
    protected $message = '';
    public function render()
    {
        return response()->json([
            'error' => class_basename($this),
            'message' => $this->message
        ], 401);
    }
}
