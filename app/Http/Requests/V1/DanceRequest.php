<?php

namespace App\Http\Requests\V1;

use App\Traits\RequestSourceHandler;
use Illuminate\Foundation\Http\FormRequest;

class DanceRequest extends FormRequest
{
    use RequestSourceHandler;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->authorizeRequest($this->request, ['dance_create', 'dance_update']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'dance_type_id' => 'required|exists:dance_types,id',
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
