<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizAnswerResource extends JsonResource
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
            'student_id' => $this->student_id,
            'quiz_id' => $this->quiz_id,
            'student' => new StudentResource($this->whenLoaded('student')),
            'quiz' => new QuizResource($this->whenLoaded('quiz')),
            'picture' => $this->picture,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
