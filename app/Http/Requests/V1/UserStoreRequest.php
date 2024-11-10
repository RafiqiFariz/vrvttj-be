<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UserStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('user_create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'nrp' => 'required_if:role_id,2|string|unique:lecturers,nrp',
            'nim' => 'required_if:role_id,3|string|unique:students,nim',
            'gender' => 'nullable|string|in:0,1',
            'place_of_birth' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'phone' => 'nullable|string|min:10|unique:users,phone',
            'photo' => 'nullable|string', // photo sudah ditangani endpoint upload
            'religion' => 'nullable|string|in:islam,kristen,katolik,hindu,budha,konghucu,lainnya',
            'role_id' => 'required|exists:roles,id',
            'address' => 'nullable|string',
        ];
    }
}
