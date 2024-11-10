<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class DanceClothesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows(['dance_cloth_create', 'dance_cloth_update']);
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
            'asset_path' => 'required|file|max:102400',
            'picture' => 'required|image|max:2048',
            'description' => 'nullable|string',
        ];

        if ($this->hasFile('asset_path')) {
            $modelExt = $this->file('asset_path')->getClientOriginalExtension();
            $allowedExt = ['obj', 'fbx', 'glb', 'gltf'];

            if (!in_array($modelExt, $allowedExt)) {
                return [
                    'error' => ['Invalid file extension. Allowed extensions are obj, fbx, glb, gltf.']
                ];
            }
        }

        return $rules;
    }
}
