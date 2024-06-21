<?php

namespace Support\Contracts;

use Illuminate\Http\Resources\Json\JsonResource;

interface ResourcableModel
{
    public function toResource(array $parameters): JsonResource;
}
