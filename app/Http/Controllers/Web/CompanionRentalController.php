<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\CompanionRental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CompanionRentalController extends Controller
{
    /**
     * Display the Rent Boyfriend / Girlfriend & Partner Registration form.
     */
    public function show(Request $request)
    {
        $defaultType = $request->query('mode', 'client'); // 'client' or 'partner'
        $defaultTarget = $request->query('target', 'girlfriend'); // 'girlfriend' or 'boyfriend'

        $totalRequests = CompanionRental::count();
        $displayClients = 1840 + CompanionRental::where('type', 'client')->count();
        $displayPartners = 460 + CompanionRental::where('type', 'partner')->count();

        return view('pages.rent-companion', [
            'appName' => config('app.name', 'Dice Madly'),
            'defaultType' => in_array($defaultType, ['client', 'partner']) ? $defaultType : 'client',
            'defaultTarget' => in_array($defaultTarget, ['boyfriend', 'girlfriend', 'both']) ? $defaultTarget : 'girlfriend',
            'displayClients' => number_format($displayClients),
            'displayPartners' => number_format($displayPartners),
            'totalRequests' => $totalRequests,
        ]);
    }

    /**
     * Store a survey rental request or partner registration.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:client,partner',
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'phone' => 'required|string|max:25',
            'gender' => 'required|in:Male,Female,Other',
            'rent_target' => 'required|in:boyfriend,girlfriend,both',
            'age' => 'nullable|integer|min:18|max:99',
            'city' => 'nullable|string|max:100',
            'duration_hours' => 'nullable|string|max:100',
            'budget_or_rate' => 'nullable|string|max:100',
            'hobbies_interests' => 'nullable|string|max:1000',
            'partner_experience' => 'nullable|string|max:1000',
            'remarks' => 'nullable|string|max:2000',
            'agree_guidelines' => 'accepted',
        ], [
            'name.required' => 'Please provide your full name.',
            'email.required' => 'Please enter a valid email address.',
            'phone.required' => 'Please provide your mobile contact number.',
            'gender.required' => 'Please select your gender.',
            'rent_target.required' => 'Please choose your rental preference (Boyfriend or Girlfriend).',
            'age.min' => 'You must be at least 18 years old to access or register for companion services.',
            'agree_guidelines.accepted' => 'Please acknowledge that you agree to our safety code and community guidelines.',
        ]);

        // Generate clean unique reference number
        $prefix = $validated['type'] === 'partner' ? 'DM-PTR-' : ($validated['rent_target'] === 'boyfriend' ? 'DM-RBF-' : 'DM-RGF-');
        do {
            $referenceNo = $prefix . strtoupper(Str::random(6));
        } while (CompanionRental::where('reference_no', $referenceNo)->exists());

        $entry = CompanionRental::create([
            'reference_no' => $referenceNo,
            'type' => $validated['type'],
            'name' => trim($validated['name']),
            'email' => strtolower(trim($validated['email'])),
            'phone' => trim($validated['phone']),
            'gender' => $validated['gender'],
            'rent_target' => $validated['rent_target'],
            'age' => $validated['age'] ?? null,
            'city' => $validated['city'] ?? null,
            'duration_hours' => $validated['duration_hours'] ?? null,
            'budget_or_rate' => $validated['budget_or_rate'] ?? null,
            'hobbies_interests' => $validated['hobbies_interests'] ?? null,
            'partner_experience' => $validated['partner_experience'] ?? null,
            'remarks' => $validated['remarks'] ?? null,
            'status' => 'pending',
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 500),
            'admin_notes' => null,
        ]);

        Log::info("Companion Rental survey recorded: [{$entry->reference_no}] Type: {$entry->type}, Target: {$entry->rent_target}, Name: {$entry->name}");

        $successPayload = [
            'reference_no' => $entry->reference_no,
            'name' => $entry->name,
            'email' => $entry->email,
            'type' => $entry->type,
            'rent_target' => $entry->rent_target_label,
            'message' => $entry->type === 'partner'
                ? "Thank you for registering as a Rental Companion Partner, {$entry->name}! Our team will review your application and contact you on {$entry->phone} / {$entry->email} for verification."
                : "Thank you {$entry->name}! Your interest in renting a {$entry->rent_target_label} has been registered securely. Reference Code: {$entry->reference_no}.",
        ];

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $successPayload,
            ], 201);
        }

        return redirect()->route('rent-companion', [
            'mode' => $entry->type,
            'target' => $entry->rent_target,
        ])->with('rental_success', $successPayload);
    }
}
