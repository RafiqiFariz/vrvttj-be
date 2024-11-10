<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DanceMoveResource extends JsonResource
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
            'dance_id' => $this->dance_id,
            'dance_part_id' => $this->dance_part_id,
            'dance' => new DanceTypeResource($this->whenLoaded('dance')),
            'dance_part' => new DancePartResource($this->whenLoaded('dancePart')),
            'picture' => $this->picture,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
