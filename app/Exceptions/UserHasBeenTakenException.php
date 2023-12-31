<?php

namespace App\Exceptions;

use Exception;

class UserHasBeenTakenException extends Exception
{
    protected $message = 'This User has been taken';
    public function render()
    {
        return response()->json([
            'error' => class_basename($this),
            'message' => $this->message
        ], 400);
    }
}
