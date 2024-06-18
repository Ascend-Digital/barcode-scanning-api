<?php

namespace App\Api\V1\Barcodes\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ScannableResource extends JsonResource
{
    public function __construct($resource, protected $parameters = [])
    {
        parent::__construct($resource);
    }
}
