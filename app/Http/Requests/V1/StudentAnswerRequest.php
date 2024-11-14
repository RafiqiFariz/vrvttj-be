<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StudentAnswerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows(['student_answer_create', 'student_answer_update']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'quiz_attempt_id' => 'required|exists:quiz_attempts,id',
            'quiz_question_id' => 'required|exists:quiz_questions,id',
            'quiz_option_id' => 'required|exists:quiz_options,id',
            'is_correct' => 'required|boolean',
        ];
    }
}
