<?php

namespace App\Http\Requests\Api\v1\Auth;

use Illuminate\Foundation\Http\FormRequest;

class BioDpRequest extends FormRequest
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
            'about_me' => 'required|string|min:10|max:1000',
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        ];
    }
}
