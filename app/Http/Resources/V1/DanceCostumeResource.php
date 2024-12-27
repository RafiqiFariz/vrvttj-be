<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DanceCostumeResource extends JsonResource
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
            'asset_path' => $this->asset_path,
            'picture' => $this->picture,
            'description' => $this->description,
            'dance' => new DanceTypeResource($this->whenLoaded('dance')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
