<?php

namespace App\Http\Requests\Api\v1\Profile;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'first_name' => 'sometimes|required|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'gender' => 'sometimes|required|in:Male,Female',
            'dob' => 'sometimes|required|date|before:today',
            'qualification' => 'sometimes|required|string|max:255',
            'profession' => 'sometimes|required|string|max:255',
            'country' => 'sometimes|required|string|max:255',
            'state' => 'sometimes|required|string|max:255',
            'city' => 'sometimes|required|string|max:255',
            'mother_tongue' => 'sometimes|required|string|max:255',
            'mother_tounge' => 'sometimes|required|string|max:255',
        ];
    }
}
