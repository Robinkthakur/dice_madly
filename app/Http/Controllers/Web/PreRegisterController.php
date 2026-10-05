<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\PreRegisterUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PreRegisterController extends Controller
{
    /**
     * Show the pre-registration early access page.
     */
    public function show()
    {
        $preRegisteredCount = PreRegisterUser::count();
        // Social proof baseline count + actual count
        $displayCount = 1250 + $preRegisteredCount;

        return view('pages.pre-register', [
            'appName' => config('app.name', 'Dice Madly'),
            'displayCount' => number_format($displayCount),
            'actualCount' => $preRegisteredCount,
        ]);
    }

    /**
     * Handle pre-registration submission.
     */
    public function store(Request $request)
    {
        // Custom check for already registered email to give a friendly response instead of raw validation error
        $existing = PreRegisterUser::where('email', $request->input('email'))->first();
        if ($existing) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'already_registered' => true,
                    'message' => 'Great news! You are already on our pre-registration list. We will notify you the moment Dice Madly launches in Bangalore.',
                    'data' => [
                        'name' => $existing->name,
                        'email' => $existing->email,
                        'vip_ticket' => $existing->vip_ticket,
                    ],
                ]);
            }

            return redirect()->route('pre-register')->with('info_notice', [
                'name' => $existing->name,
                'email' => $existing->email,
                'ticket' => $existing->vip_ticket,
                'message' => "You're already registered! We have your email ({$existing->email}) safely stored on our pre-registration list (Ticket: " . ($existing->vip_ticket ?? 'Active') . "). Watch your inbox for official launch updates!",
            ]);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:pre_registered_users,email',
            'phone' => 'nullable|string|max:25',
            'gender' => 'nullable|in:Male,Female,Other',
            'age' => 'nullable|integer|min:18|max:99',
            'city' => 'nullable|string|max:100',
            'interested_in' => 'nullable|in:dating,matrimony,both',
            'preferred_platform' => 'required|in:android,ios,both',
            'agree_terms' => 'accepted',
        ], [
            'name.required' => 'Please enter your name.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered on our early access list.',
            'age.min' => 'Dice Madly is for adults aged 18 and older.',
            'age.max' => 'Please enter a valid age.',
            'agree_terms.accepted' => 'Please acknowledge that you wish to receive early access launch updates.',
        ]);

        // Generate unique VIP Ticket code
        do {
            $vipTicket = 'DM-VIP-' . strtoupper(Str::random(6));
        } while (PreRegisterUser::where('vip_ticket', $vipTicket)->exists());

        $entry = PreRegisterUser::create([
            'vip_ticket' => $vipTicket,
            'name' => $validated['name'],
            'email' => strtolower(trim($validated['email'])),
            'phone' => $validated['phone'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'age' => $validated['age'] ?? null,
            'city' => $validated['city'] ?? null,
            'interested_in' => $validated['interested_in'] ?? 'both',
            'preferred_platform' => $validated['preferred_platform'],
            'status' => 'pending',
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 500),
            'notes' => 'Early Access Web Registration',
        ]);

        Log::info("Pre-registration successful for: {$entry->email} ({$entry->name}) [Ticket: {$entry->vip_ticket}]");

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Congratulations! You are officially pre-registered for Dice Madly.',
                'data' => [
                    'id' => $entry->id,
                    'name' => $entry->name,
                    'email' => $entry->email,
                    'vip_ticket' => $entry->vip_ticket,
                ],
            ], 201);
        }

        return redirect()->route('pre-register')->with('pre_register_success', [
            'name' => $entry->name,
            'email' => $entry->email,
            'ticket' => $entry->vip_ticket,
            'platform' => ucfirst($entry->preferred_platform),
            'message' => "Welcome aboard, {$entry->name}! You have successfully reserved your pre-registration spot on Dice Madly.",
        ]);
    }
}
