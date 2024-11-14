<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizResultResource extends JsonResource
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
            'quiz_id' => $this->quiz_id,
            'student_id' => $this->student_id,
            'total_questions' => $this->total_questions,
            'correct_answers' => $this->correct_answers,
            'wrong_answers' => $this->wrong_answers,
            'final_score' => $this->final_score,
            'completed_at' => $this->completed_at,
            'quiz' => new QuizResource($this->whenLoaded('quiz')),
            'student' => new StudentResource($this->whenLoaded('student')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
