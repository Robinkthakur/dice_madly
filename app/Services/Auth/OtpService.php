<?php

namespace App\Services\Auth;

use App\Models\OtpCode;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Exception;

class OtpService
{
    /**
     * Create a new OtpService instance.
     */
    public function __construct(protected SmsService $smsService)
    {
    }

    /**
     * Generate and send an OTP code.
     *
     * @param string $type ('email' or 'phone')
     * @param string $value (the email or phone number)
     * @return OtpCode
     * @throws Exception
     */
    public function generateAndSend(string $type, string $value): OtpCode
    {
        // 1. Rate limiting / Throttling check (e.g. 60 seconds)
        $latestOtp = OtpCode::where('type', $type)
            ->where('value', $value)
            ->latest()
            ->first();

        if ($latestOtp && $latestOtp->created_at->addSeconds(60)->isFuture()) {
            $secondsRemaining = $latestOtp->created_at->addSeconds(60)->diffInSeconds(now());
            throw new Exception("Please wait {$secondsRemaining} seconds before requesting a new OTP.");
        }

        // 2. Generate 6-digit OTP code
        // For development/local environment, we can optionally use a fixed OTP or generate a random one.
        // Let's generate a random 6-digit one.
        $code = (string) rand(100000, 999999);

        // In local environment, you could configure a constant code for easier app development:
        if (config('app.env') === 'testing') {
            $code = '123456';
        }

        // 3. Save OTP to DB
        $otpCode = OtpCode::create([
            'type' => $type,
            'value' => $value,
            'code' => $code, // Keeping it raw for simplicity, with a short expiration
            'expires_at' => now()->addMinutes(10), // 10 minutes expiry
            'is_verified' => false,
        ]);

        // 4. Send via appropriate channel
        if ($type === 'email') {
            Mail::to($value)->send(new OtpMail($code));
        } else {
            $this->smsService->sendOtp($value, $code);
        }

        return $otpCode;
    }

    /**
     * Verify the OTP code.
     *
     * @param string $type
     * @param string $value
     * @param string $code
     * @return bool
     */
    public function verify(string $type, string $value, string $code): bool
    {
        // For local development testing convenience, let's accept 123456 as a universal debug code
        if (config('app.env') === 'local' && $code === '123456') {
            // Find any unexpired, unverified OTP code for this user and mark it verified,
            // or if none exists, just return true so they can log in/test easily.
            $otp = OtpCode::where('type', $type)
                ->where('value', $value)
                ->where('is_verified', false)
                ->latest()
                ->first();
            if ($otp) {
                $otp->update(['is_verified' => true]);
            }
            return true;
        }

        // Find standard match
        $otp = OtpCode::where('type', $type)
            ->where('value', $value)
            ->where('code', $code)
            ->where('is_verified', false)
            ->where('expires_at', '>', now())
            ->first();

        if (!$otp) {
            return false;
        }

        // Mark OTP as verified
        $otp->update(['is_verified' => true]);

        return true;
    }
}
