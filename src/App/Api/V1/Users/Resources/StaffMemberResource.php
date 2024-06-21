<?php

namespace App\Api\V1\Users\Resources;

use App\Api\V1\Barcodes\Resources\ScannableActionResource;
use App\Api\V1\Barcodes\Resources\ScannableResource;
use App\Api\V1\Companies\Resources\CompanyResource;
use Illuminate\Http\Request;

class StaffMemberResource extends ScannableResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => 'StaffMember',
            'name' => $this->user->name,
            'company' => new CompanyResource($this->whenLoaded('company')),
            'actions' => ScannableActionResource::collection($this->actions()),
        ];
    }
}
