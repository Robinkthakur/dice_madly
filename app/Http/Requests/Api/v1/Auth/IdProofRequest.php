<?php

namespace App\Http\Requests\Api\v1\Auth;

use Illuminate\Foundation\Http\FormRequest;

class IdProofRequest extends FormRequest
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
            'id_type' => 'required|string|in:Passport,Aadhaar,Driving License,Voter ID,National ID',
            'id_document' => 'required|file|mimes:jpeg,png,jpg,pdf|max:10240',
        ];
    }
}
