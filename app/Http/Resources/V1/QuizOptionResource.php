<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizOptionResource extends JsonResource
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
            'quiz_question_id' => $this->quiz_question_id,
            'answer' => $this->answer,
            'is_correct' => $this->is_correct,
            'question' => new QuizQuestionResource($this->whenLoaded('question')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
