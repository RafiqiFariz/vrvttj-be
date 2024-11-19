<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class QuizResultRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows(['quiz_result_create', 'quiz_result_update']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'quiz_id' => 'required|exists:quizzes,id',
            'student_id' => 'required|exists:students,id',
            'total_questions' => 'required|numeric',
            'correct_answers' => 'required|numeric',
            'wrong_answers' => 'required|numeric',
            'final_score' => 'required|numeric',
            'completed_at' => 'required|datetime',
        ];
    }
}