<?php

namespace App\Http\Controllers\Api\v1\Payment;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Subscription;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    /**
     * List all available premium packages (plans).
     */
    public function plans(): JsonResponse
    {
        $packages = Package::all();

        return response()->json([
            'success' => true,
            'data' => $packages
        ]);
    }

    /**
     * Initialize payment order (Razorpay integration).
     */
    public function init(Request $request): JsonResponse
    {
        $request->validate([
            'plan_id' => 'required|integer|exists:packages,id',
        ]);

        $user = $request->user();
        $packageId = $request->input('plan_id');
        $package = Package::find($packageId);

        $keyId = config('services.razorpay.key_id');
        $keySecret = config('services.razorpay.key_secret');

        $orderId = 'order_mock_' . Str::random(14);
        $gatewayName = 'Razorpay Mock';

        if ($keyId && $keySecret) {
            try {
                $response = \Illuminate\Support\Facades\Http::withBasicAuth($keyId, $keySecret)
                    ->post('https://api.razorpay.com/v1/orders', [
                        'amount' => (int) round($package->price * 100), // in paise
                        'currency' => 'INR',
                        'receipt' => 'receipt_' . Str::random(12),
                    ]);

                if ($response->successful()) {
                    $orderId = $response->json('id');
                    $gatewayName = 'Razorpay';
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to create Razorpay order: ' . $response->body(),
                    ], 500);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Razorpay API error: ' . $e->getMessage(),
                ], 500);
            }
        }

        // Create pending payment record
        $payment = Payment::create([
            'user_id' => $user->id,
            'package_id' => $packageId,
            'transaction_id' => $orderId,
            'amount' => $package->price,
            'gateway' => $gatewayName,
            'status' => 'Pending',
            'gateway_response' => [
                'order_id' => $orderId,
            ]
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Payment order initiated.',
            'data' => [
                'order_id' => $orderId,
                'payment' => $payment
            ]
        ]);
    }

    /**
     * Verify Razorpay payment signature and activate subscription.
     */
    public function verify(Request $request): JsonResponse
    {
        $request->validate([
            'transaction_id' => 'required|string|exists:payments,transaction_id',
            'razorpay_payment_id' => 'sometimes|string',
            'razorpay_order_id' => 'sometimes|string',
            'signature' => 'nullable|string',
        ]);

        $user = $request->user();
        $transactionId = $request->input('transaction_id');

        $payment = Payment::where('transaction_id', $transactionId)
            ->where('user_id', $user->id)
            ->firstOrFail();

        if ($payment->status === 'Paid') {
            return response()->json([
                'success' => false,
                'message' => 'This payment has already been verified and processed.'
            ], 422);
        }

        $keyId = config('services.razorpay.key_id');
        $keySecret = config('services.razorpay.key_secret');

        // Verify Razorpay signature if credentials are set and razorpay fields are provided
        if ($keyId && $keySecret && $request->has('razorpay_order_id') && $request->has('razorpay_payment_id')) {
            $expectedSignature = hash_hmac(
                'sha256',
                $request->input('razorpay_order_id') . '|' . $request->input('razorpay_payment_id'),
                $keySecret
            );

            if ($expectedSignature !== $request->input('signature')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid payment signature. Verification failed.'
                ], 400);
            }
        }

        // Update payment status
        $payment->update([
            'status' => 'Paid',
            'gateway_response' => [
                'razorpay_payment_id' => $request->input('razorpay_payment_id'),
                'razorpay_order_id' => $request->input('razorpay_order_id'),
                'signature' => $request->input('signature') ?? 'mock_signature_123',
                'verified_at' => now()->toIso8601String()
            ]
        ]);

        // Deactivate existing subscriptions if any
        Subscription::where('user_id', $user->id)
            ->where('status', 'Active')
            ->update(['status' => 'Expired']);

        $package = Package::find($payment->package_id);

        // Create active subscription
        $subscription = Subscription::create([
            'user_id' => $user->id,
            'package_id' => $payment->package_id,
            'start_date' => now()->toDateString(),
            'end_date' => now()->addDays($package->duration_days)->toDateString(),
            'status' => 'Active',
        ]);

        // Update user premium verification status in users table
        $user->update([
            'is_verified' => true,
            'verified_until' => $subscription->end_date,
        ]);

        // Trigger premium activated notification
        \App\Models\Notification::create([
            'user_id' => $user->id,
            'title' => 'Premium Activated!',
            'message' => "Your {$package->name} subscription is now active! Enjoy premium features.",
            'type' => 'premium',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Payment verified successfully. Subscription activated!',
            'data' => [
                'subscription' => $subscription
            ]
        ]);
    }
}
