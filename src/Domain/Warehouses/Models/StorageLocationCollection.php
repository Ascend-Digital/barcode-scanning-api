<?php

namespace Domain\Warehouses\Models;

use App\Exceptions\IncompleteProcessException;
use Illuminate\Database\Eloquent\Collection;

class StorageLocationCollection extends Collection
{
    public function validate($storageLocationId)
    {
        throw_if($missingPrerequisites->isNotEmpty(), new IncompleteProcessException($missingPrerequisites));

    }
}
