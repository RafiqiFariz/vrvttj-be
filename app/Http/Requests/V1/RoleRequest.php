<?php

namespace App\Http\Requests\V1;

use App\Traits\RequestSourceHandler;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class RoleRequest extends FormRequest
{
    use RequestSourceHandler;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(Request $request): bool
    {
        return $this->authorizeRequest($request, ['role_access', 'role_create']);
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
            'permissions' => 'array',
            'permissions.*' => 'integer|exists:permissions,id',
        ];
    }
}
