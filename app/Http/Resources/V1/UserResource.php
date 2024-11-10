<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'gender' => $this->gender,
            'email' => $this->email,
            'phone' => $this->phone,
            'photo' => $this->photo,
            'place_of_birth' => $this->place_of_birth,
            'date_of_birth' => $this->date_of_birth,
            'religion' => $this->religion,
            'role_id' => $this->role_id,
            'role' => new RoleResource($this->whenLoaded('role')),
            'lecturer' => $this->when($this->role_id === 2, $this->lecturer),
            'student' => $this->when($this->role_id === 3, $this->student),
            'address' => $this->address,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
