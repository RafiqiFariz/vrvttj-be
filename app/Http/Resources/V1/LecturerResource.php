<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LecturerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'nrp' => $this->nrp,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
                'phone' => $this->user->phone,
                'role_id' => $this->user->role_id,
                'role' => $this->user->role,
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
