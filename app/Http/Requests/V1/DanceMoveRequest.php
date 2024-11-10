<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class DanceMoveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows(['dance_move_create', 'dance_move_update']);
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
            'dance_id' => 'required|exists:dances,id',
            'dance_part_id' => 'required|exists:dance_parts,id',
            'description' => 'nullable|string',
        ];

        if ($this->isMethod('put') && $this->hasFile('picture')) {
            $rules['picture'] = 'required|mimes:jpeg,jpg,png|max:2048';
        }

        return $rules;
    }
}
