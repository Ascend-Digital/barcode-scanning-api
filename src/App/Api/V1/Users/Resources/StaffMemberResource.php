<?php

namespace App\Api\V1\Users\Resources;

use App\Api\V1\Companies\Resources\CompanyResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StaffMemberResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => 'StaffMember',
            'name' => $this->user->name,
            'company' => new CompanyResource($this->whenLoaded('company')),
            'actions' => [],
        ];
    }
}
