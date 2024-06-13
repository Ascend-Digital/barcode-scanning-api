<?php

namespace App\Exceptions;

use App\Api\V1\Processes\Resources\ProcessCollection;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IncompleteProcessException extends Exception
{
    public function __construct(private readonly ProcessCollection $prerequisites)
    {
        parent::__construct(
            message: 'The following prerequisites are incomplete: '.$this->prerequisites->implode('name', ', '),
            code: 422
        );
    }

    public function render(Request $request): JsonResponse
    {
        return response()->json([
            'message' => $this->getMessage(),
            'prerequisites' => $this->prerequisites,
        ], $this->getCode());
    }
}
