<?php

namespace App\Http\Requests\V1;

use App\Traits\RequestSourceHandler;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class DanceMoveRequest extends FormRequest
{
    use RequestSourceHandler;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(Request $request): bool
    {
        return $this->authorizeRequest($request, ['dance_move_create', 'dance_move_update']);
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
