<?php

namespace App\Services\Auth;

use Illuminate\Support\Facades\Log;

class SmsService
{
    /**
     * Send an OTP via SMS.
     *
     * @param string $phone
     * @param string $code
     * @return bool
     */
    public function sendOtp(string $phone, string $code): bool
    {
        // For local development, we log the OTP to Laravel logs.
        // In production, this can be swapped with Twilio, MSG91, Firebase, etc.
        Log::info("SMS OTP Simulation: Send OTP code [{$code}] to phone [{$phone}]");
        
        return true;
    }
}
