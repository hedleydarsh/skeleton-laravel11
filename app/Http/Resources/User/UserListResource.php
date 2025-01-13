<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $image = $this->resource->image ? env('AWS_URL') . $this->resource->image : null;
        $roles = $this->resource->roles->pluck('name')->toArray();

        return [
            ...$this->resource->toArray(),
            'image' => $image,
            'roles' => $roles,
        ];
    }
}
