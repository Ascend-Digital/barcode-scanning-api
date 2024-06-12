<?php

namespace App\Api\V1\Processes\Resources;

use App\Exceptions\IncompleteProcessException;
use Illuminate\Database\Eloquent\Collection;
use Throwable;

class ProcessCollection extends Collection
{
    /**
     * @throws Throwable
     */
    public function validate($allPrerequisites): void
    {
        $missingPrerequisites = new ProcessCollection($allPrerequisites->filter(function ($prerequisite) {
            return ! $this->contains($prerequisite);
        }));

        throw_if($missingPrerequisites->isNotEmpty(), new IncompleteProcessException($missingPrerequisites));
    }
}
