<?php

namespace App\Http\Requests\V1;

use App\Traits\RequestSourceHandler;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    use RequestSourceHandler;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(Request $request): bool
    {
        return $this->authorizeRequest($request, 'user_update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->request->get('id');
        $studentId = optional($this->request->all('student'))['id'];
        $lecturerId = optional($this->request->all('lecturer'))['id'];
        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($id),
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'nrp' => [
                'required_if:role_id,2',
                'string',
                Rule::unique('lecturers', 'nrp')->ignore($lecturerId),
            ],
            'nim' => [
                'required_if:role_id,3',
                'string',
                Rule::unique('students', 'nim')->ignore($studentId),
            ],
            'gender' => 'nullable|string|in:0,1',
            'place_of_birth' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'phone' => [
                'nullable',
                'string',
                'min:10',
                Rule::unique('users', 'phone')->ignore($id),
            ],
            'photo' => 'nullable|string', // photo sudah ditangani endpoint upload
            'religion' => 'nullable|string|in:islam,kristen,katolik,hindu,budha,konghucu,lainnya',
            'role_id' => 'required|exists:roles,id',
            'address' => 'nullable|string',
        ];
    }
}
