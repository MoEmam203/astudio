<?php

namespace App\Http\Requests\Api\Projects;

use Illuminate\Foundation\Http\FormRequest;

class AttachProjectsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'projects' => 'required|array',
            'projects.*' => 'required|exists:projects,id',
        ];
    }
}
