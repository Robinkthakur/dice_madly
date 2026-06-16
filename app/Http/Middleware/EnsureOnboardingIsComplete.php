<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureOnboardingIsComplete
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->onboarding_step !== 'completed') {
            // Permit onboarding setup routes and the "me" progress endpoint
            if ($request->is('api/v1/auth/profile/*') || $request->is('api/v1/auth/me')) {
                return $next($request);
            }

            return response()->json([
                'success' => false,
                'message' => 'Please complete your profile setup first.',
                'data' => [
                    'onboarding_step' => $user->onboarding_step ?? 'bio_dp',
                ]
            ], 403);
        }

        return $next($request);
    }
}
