<?php

namespace App\Exceptions;

use App\Api\V1\Processes\Resources\ProcessCollection;
use Exception;

class IncompleteProcessException extends Exception
{
    public function __construct(private ProcessCollection $prerequisites)
    {
        parent::__construct(
            message: 'The following prerequisites are incomplete: '.$this->prerequisites->implode('name', ', '),
            code: 422
        );

    }

    public function render(\Illuminate\Http\Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'message' => $this->getMessage(),
            'prerequisites' => $this->prerequisites,
        ], $this->getCode());
    }
}
