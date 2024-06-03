<?php

namespace App\Api\V1\Processes\Resources;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Validation\ValidationException;
use Throwable;

class ProcessCollection extends Collection
{
    /**
     * @throws Throwable
     */
    public function validate($allPrerequisites): void
    {
//        dd($this->reverse());
        throw_if($this->intersect($allPrerequisites)->isNotEmpty(), ValidationException::withMessages([$this->reverse()]));
    }
}
