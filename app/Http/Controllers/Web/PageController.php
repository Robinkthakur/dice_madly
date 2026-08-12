<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PageController extends Controller
{
    /**
     * Display the Dice Madly homepage / landing page.
     */
    public function home()
    {
        return view('pages.home', [
            'appName' => config('app.name', 'Dice Madly'),
            'googlePlayUrl' => '#download-app',
            'appStoreUrl' => '#download-app',
            'totalMatches' => '250K+',
            'activeUsers' => '100K+',
            'satisfactionRate' => '98.6%',
        ]);
    }

    /**
     * Display the Google Play compliant Privacy Policy.
     */
    public function privacy()
    {
        return view('pages.privacy', [
            'appName' => config('app.name', 'Dice Madly'),
            'lastUpdated' => 'August 12, 2026',
            'contactEmail' => 'privacy@dicemadly.com',
            'supportEmail' => 'support@dicemadly.com',
        ]);
    }

    /**
     * Display the Terms and Conditions / Terms of Service.
     */
    public function terms()
    {
        return view('pages.terms', [
            'appName' => config('app.name', 'Dice Madly'),
            'lastUpdated' => 'August 12, 2026',
            'contactEmail' => 'legal@dicemadly.com',
        ]);
    }

    /**
     * Display the Google Play Account & Data Deletion policy page and form.
     */
    public function deleteAccount()
    {
        return view('pages.delete-account', [
            'appName' => config('app.name', 'Dice Madly'),
            'supportEmail' => 'support@dicemadly.com',
        ]);
    }

    /**
     * Handle the web account and data deletion request (Google Play compliance).
     */
    public function submitDeleteAccountRequest(Request $request)
    {
        $validated = $request->validate([
            'identifier' => 'required|string|max:255',
            'identifier_type' => 'required|in:email,phone',
            'reason' => 'nullable|string|max:1000',
            'confirm_checkbox' => 'accepted',
        ], [
            'identifier.required' => 'Please provide your registered email address or phone number.',
            'confirm_checkbox.accepted' => 'You must acknowledge and confirm the account deletion request.',
        ]);

        $referenceId = 'DMD-DEL-' . strtoupper(Str::random(8));

        // Attempt to find user and process soft deletion if matching record is present
        $user = null;
        if ($validated['identifier_type'] === 'email') {
            $user = User::where('email', $validated['identifier'])->first();
        } else {
            $cleanPhone = preg_replace('/[^0-9]/', '', $validated['identifier']);
            $user = User::where('phone', 'like', "%{$cleanPhone}%")->first();
        }

        if ($user) {
            // Revoke all tokens
            $user->tokens()->delete();
            // Soft delete user record
            $user->delete();

            Log::info("Web account deletion executed for user ID: {$user->id}, Reference: {$referenceId}, Reason: " . ($validated['reason'] ?? 'Not specified'));
        } else {
            Log::warning("Web account deletion requested for unverified identifier: {$validated['identifier']}, Reference: {$referenceId}");
        }

        return redirect()->route('delete-account')->with('success_request', [
            'reference' => $referenceId,
            'identifier' => $validated['identifier'],
            'message' => 'Your account deletion request has been submitted successfully. Your profile, photos, and messages are queued for permanent deletion within our 15-30 day security grace period.',
        ]);
    }

    /**
     * Display the Community Guidelines & Safe Dating tips.
     */
    public function communityGuidelines()
    {
        return view('pages.community-guidelines', [
            'appName' => config('app.name', 'Dice Madly'),
            'lastUpdated' => 'August 12, 2026',
            'safetyEmail' => 'safety@dicemadly.com',
        ]);
    }

    /**
     * Display the In-App Purchases & Refund Policy.
     */
    public function refundPolicy()
    {
        return view('pages.refund-policy', [
            'appName' => config('app.name', 'Dice Madly'),
            'lastUpdated' => 'August 12, 2026',
            'billingEmail' => 'billing@dicemadly.com',
        ]);
    }

    /**
     * Display the Contact & Grievance Redressal page.
     */
    public function contact()
    {
        return view('pages.contact', [
            'appName' => config('app.name', 'Dice Madly'),
            'supportEmail' => 'support@dicemadly.com',
            'grievanceEmail' => 'grievance@dicemadly.com',
        ]);
    }

    /**
     * Handle contact & support submissions.
     */
    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'subject' => 'required|string|max:150',
            'category' => 'required|in:general,safety,billing,bug,privacy',
            'message' => 'required|string|min:10|max:3000',
        ]);

        $ticketId = 'DMD-TKT-' . strtoupper(Str::random(7));

        Log::info("Support Inquiry Submitted [{$ticketId}] from {$validated['email']} ({$validated['name']}) - Category: {$validated['category']}");

        return redirect()->route('contact')->with('contact_success', [
            'ticket' => $ticketId,
            'name' => $validated['name'],
            'message' => "Thank you, {$validated['name']}! Your message has been received. Our team will respond to {$validated['email']} within 24 to 48 hours.",
        ]);
    }
}
