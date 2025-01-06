<?php

namespace App\Http\Requests\V1;

use App\Traits\RequestSourceHandler;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class DancePartVideoRequest extends FormRequest
{
    use RequestSourceHandler;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(Request $request): bool
    {
        return $this->authorizeRequest($request, ['dance_part_create', 'dance_part_update']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'dance_part_id' => 'required|exists:dance_parts,id',
            'description' => 'nullable|string',
        ];

        if ($this->hasFile('thumbnail_path')) {
            $rules['thumbnail_path'] = 'required|file|mimes:jpeg,jpg,png|max:2048';
        }

        if ($this->hasFile('video_path')) {
            $rules['video_path'] = 'required|file|mimes:mp4|max:1024000';
        }

        return $rules;
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'thumbnail_path.required' => 'The thumbnail is required.',
            'thumbnail_path.file' => 'The thumbnail must be a file.',
            'thumbnail_path.mimes' => 'The thumbnail must be a file of type: jpeg, jpg, png.',
            'thumbnail_path.max' => 'The thumbnail may not be greater than 2048 kilobytes.',
            'video_path.required' => 'The video is required.',
            'video_path.file' => 'The video must be a file.',
            'video_path.mimes' => 'The video must be a file of type: mp4.',
            'video_path.max' => 'The video may not be greater than 1024000 kilobytes.',
        ];
    }
}
