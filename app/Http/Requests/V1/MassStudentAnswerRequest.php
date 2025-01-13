<?php

namespace App\Http\Requests\V1;

use App\Traits\RequestSourceHandler;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class MassStudentAnswerRequest extends FormRequest
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
            '*.quiz_attempt_id' => 'required|exists:quiz_attempts,id',
            '*.quiz_question_id' => 'required|exists:quiz_questions,id',
            '*.quiz_option_id' => 'required|exists:quiz_options,id',
            '*.is_correct' => 'required|boolean',
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            '*.quiz_attempt_id.exists' => 'The selected quiz attempt is not found.',
            '*.quiz_question_id.exists' => 'The selected quiz question is not found.',
            '*.quiz_option_id.exists' => 'The selected quiz option is not found.',
        ];
    }
}
