<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class InvalidItemQuantityException extends Exception
{
    public function __construct()
    {
        parent::__construct(
            message: 'Cannot pick a larger item quantity than is available',
            code: ResponseAlias::HTTP_UNPROCESSABLE_ENTITY,
        );
    }

    public function render(Request $request): JsonResponse
    {
        return response()->json([
            'message' => $this->getMessage(),
        ], $this->getCode());
    }
}
