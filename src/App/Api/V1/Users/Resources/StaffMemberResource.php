<?php

namespace App\Api\V1\Users\Resources;

use App\Api\V1\Companies\Resources\CompanyResource;
use Domain\Barcodes\Contracts\ScannableResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StaffMemberResource extends JsonResource implements ScannableResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => 'StaffMember',
            'name' => $this->name,
            'company' => new CompanyResource($this->whenLoaded('company')),
            'actions' => $this->availableActions(),
        ];
    }

    public function availableActions(): array
    {
        return [
            /*
            [
                'name' => 'Pick from storage location',
                'endpoint' => route('storage-locations.item.pick')
            ],
            */
        ];
    }
}
