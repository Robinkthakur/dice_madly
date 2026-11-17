<?php

namespace App\Http\Requests\Api\v1\Profile;

use App\Http\Requests\Traits\NormalizesImageUpload;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    use NormalizesImageUpload;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare inputs for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->normalizeProfileImage('profile_image');
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'first_name' => 'sometimes|nullable|string|max:255',
            'last_name' => 'sometimes|nullable|string|max:255',
            'gender' => 'sometimes|nullable|in:Male,Female',
            'dob' => 'sometimes|nullable|date|before:today',
            'qualification' => 'sometimes|nullable|string|max:255',
            'profession' => 'sometimes|nullable|string|max:255',
            'country' => 'sometimes|nullable|string|max:255',
            'state' => 'sometimes|nullable|string|max:255',
            'city' => 'sometimes|nullable|string|max:255',
            'mother_tongue' => 'sometimes|nullable|string|max:255',
            'mother_tounge' => 'sometimes|nullable|string|max:255',
            'profile_image' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,webp,heic,heif|max:20480',
        ];
    }
}
