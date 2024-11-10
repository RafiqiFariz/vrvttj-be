<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class QuizAnswerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows(['quiz_answer_create', 'quiz_answer_update']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'student_id' => 'required|exists:students,id',
            'quiz_id' => 'required|exists:quizzes,id',
            'answer' => 'required|string',
            'is_correct' => 'nullable|boolean',
            'score' => 'nullable|integer',
        ];
    }
}
