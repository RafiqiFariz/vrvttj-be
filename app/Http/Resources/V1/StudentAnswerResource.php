<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentAnswerResource extends JsonResource
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
            'quiz_attempt_id' => $this->quiz_attempt_id,
            'quiz_question_id' => $this->quiz_question_id,
            'quiz_option_id' => $this->quiz_option_id,
            'is_correct' => $this->is_correct,
            'attempt' => new QuizAttemptResource($this->whenLoaded('quizAttempt')),
            'question' => new QuizQuestionResource($this->whenLoaded('quizQuestion')),
            'option' => new QuizOptionResource($this->whenLoaded('quizOption')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
