<?php

namespace App\Http\Requests\V1;

use App\Traits\RequestSourceHandler;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class StudentAnswerRequest extends FormRequest
{
    use RequestSourceHandler;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(Request $request): bool
    {
        return $this->authorizeRequest($request, ['student_answer_create', 'student_answer_update']);
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
