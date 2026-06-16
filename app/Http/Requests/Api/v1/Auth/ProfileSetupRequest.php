<?php
 
namespace App\Http\Requests\Api\v1\Auth;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\OtpCode;

class ProfileSetupRequest extends FormRequest
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
            'type' => 'required|in:email,phone',
            'value' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    // Check if value equals email or phone based on type
                    if ($this->type === 'email' && $value !== $this->input('email')) {
                        $fail('The value must match the email field.');
                    }
                    if ($this->type === 'phone' && $value !== $this->input('phone')) {
                        $fail('The value must match the phone field.');
                    }

                    // For local development convenience, let's bypass OTP verification check if value matches testing/debug values
                    if (config('app.env') === 'local' && $value === 'test@example.com') {
                        return;
                    }

                    // Check if OTP was verified within the last 30 minutes
                    $otpExists = OtpCode::where('type', $this->type)
                        ->where('value', $value)
                        ->where('is_verified', true)
                        ->where('updated_at', '>=', now()->subMinutes(30))
                        ->exists();

                    if (!$otpExists) {
                        $fail('The OTP for this ' . $this->type . ' has not been verified or session has expired.');
                    }
                }
            ],
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => ['required', 'string', 'regex:/^\+?[1-9]\d{1,14}$/', 'unique:users,phone'],
            'gender' => 'required|in:Male,Female',
            'dob' => 'required|date|before_or_equal:today',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'type.in' => 'The authentication type must be either email or phone.',
            'phone.regex' => 'The phone number format must be valid (e.g., +1234567890).',
            'gender.in' => 'Gender must be Male or Female.',
            'marital_status.in' => 'Marital status must be Never Married, Divorced, Widowed, or Awaiting Divorce.',
            'dob.before_or_equal' => 'Date of birth must be a past or present date.',
        ];
    }
}
