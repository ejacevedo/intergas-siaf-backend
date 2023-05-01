<?php

namespace App\Exceptions;

use Exception;

class PersonNotFound extends Exception
{
    public function render($request, \Throwable $exception) {

        if ($exception instanceof PersonNotFoundException) {
            return response()->json(
                [
                    'success' => false,
                    'message' => "Person not found"
                ],
                400
            );
        }
        return parent::render($request, $exception);
    }
}
