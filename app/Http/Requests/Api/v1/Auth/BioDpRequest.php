<?php

namespace App\Http\Requests\Api\v1\Auth;

use App\Http\Requests\Traits\NormalizesImageUpload;
use Illuminate\Foundation\Http\FormRequest;

class BioDpRequest extends FormRequest
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
     * Prepare inputs for validation (normalize image aliases and Base64).
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
            'about_me' => 'nullable|string|max:1000',
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,webp,heic,heif|max:20480',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'profile_image.required' => 'Please provide a profile image (as a file or base64 under profile_image or image).',
            'profile_image.image' => 'The uploaded file must be a valid image.',
            'profile_image.mimes' => 'The image must be a file of type: jpeg, png, jpg, webp, heic, heif.',
            'profile_image.max' => 'The image size may not be greater than 20MB.',
        ];
    }
}
