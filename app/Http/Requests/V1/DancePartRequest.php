<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class DancePartRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows(['dance_part_create', 'dance_part_update']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'picture' => 'nullable',
            'description' => 'nullable|string',
        ];

        if ($this->hasFile('picture')) {
            $rules['picture'] = 'required|mimes:jpeg,jpg,png|max:2048';
        }

        return $rules;
    }
}
