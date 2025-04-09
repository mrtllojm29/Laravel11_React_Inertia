<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Allow all users to make this request.
     * You can customize this for authorization logic.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules for updating a task.
     * These rules ensure correct and valid input data.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Task name is required and limited to 255 characters
            "name" => ['required', 'max:255'],

            // Image is optional but must be a valid image if present
            'image' => ['nullable', 'image'],

            // Description is optional
            "description" => ['nullable', 'string'],

            // Due date is optional and must be a valid date format
            'due_date' => ['nullable', 'date'],

            // Project must exist in the database
            'project_id' => ['required', 'exists:projects,id'],

            // Assigned user must exist in the database
            'assigned_user_id' => ['required', 'exists:users,id'],

            // Task status must be one of the predefined values
            'status' => [
                'required',
                Rule::in(['pending', 'in_progress', 'completed'])
            ],

            // Priority must be one of the predefined values
            'priority' => [
                'required',
                Rule::in(['low', 'medium', 'high'])
            ]
        ];
    }
}
