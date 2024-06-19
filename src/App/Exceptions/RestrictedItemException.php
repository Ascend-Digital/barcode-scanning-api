<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class RestrictedItemException extends Exception
{
    public function __construct()
    {
        parent::__construct(
            message: 'Item cannot be placed in this storage location',
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
