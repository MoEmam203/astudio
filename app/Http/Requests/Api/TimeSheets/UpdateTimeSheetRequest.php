<?php

namespace App\Http\Requests\Api\TimeSheets;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTimeSheetRequest extends FormRequest
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
            'task_name' => 'required|string|max:255',
            'date' => 'required|date',
            'hours' => 'required|numeric|min:1',
            'project_id' => 'required|exists:projects,id',
        ];
    }
}
