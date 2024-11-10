<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class QuizRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows(['quiz_create', 'quiz_update']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => 'required|in:pilihan_ganda,benar_salah,esai',
            'question' => 'required|string',
            'answer_key' => 'nullable|string',
        ];
    }
}
