<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DanceResource extends JsonResource
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
            'dance_type_id' => $this->dance_type_id,
            'name' => $this->name,
            'picture' => $this->picture,
            'description' => $this->description,
            'dance_type' => new DanceTypeResource($this->danceType),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
