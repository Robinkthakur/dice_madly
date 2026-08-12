<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\UserLog;
use Symfony\Component\HttpFoundation\Response;

class LogUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Check which guard is currently authenticated
        $user = null;
        $guardUsed = null;
        foreach (['admin', 'sanctum', 'web', 'api'] as $guard) {
            try {
                if (auth()->guard($guard)->check()) {
                    $user = auth()->guard($guard)->user();
                    $guardUsed = $guard;
                    break;
                }
            } catch (\Throwable $e) {
                // Ignore if guard is not defined
            }
        }

        if ($user) {
            if ($user instanceof \App\Models\User) {
                // Update user last seen timestamp quietly to not trigger events
                $user->updateQuietly(['last_seen_at' => now()]);
            }

            // Exclude admin logs, only store API users logs
            if ($user instanceof \App\Models\Admin || $guardUsed === 'admin' || $request->is('admin*') || str_contains($request->path(), 'admin/')) {
                return $response;
            }

            $action = $request->method() . ' ' . $request->path();
            
            // Get module name from path segments
            $segments = $request->segments();
            $module = $segments[1] ?? ($segments[0] ?? 'general');

            // Simple user agent parsing
            $userAgent = $request->userAgent();
            $platform = 'Unknown';
            $browser = 'Unknown';
            $deviceType = 'Desktop';

            if ($userAgent) {
                if (preg_match('/android/i', $userAgent)) {
                    $platform = 'Android';
                    $deviceType = 'Mobile';
                } elseif (preg_match('/iphone|ipad|ipod/i', $userAgent)) {
                    $platform = 'iOS';
                    $deviceType = 'Mobile';
                } elseif (preg_match('/windows/i', $userAgent)) {
                    $platform = 'Windows';
                } elseif (preg_match('/macintosh|mac os x/i', $userAgent)) {
                    $platform = 'macOS';
                } elseif (preg_match('/linux/i', $userAgent)) {
                    $platform = 'Linux';
                }

                if (preg_match('/chrome/i', $userAgent)) {
                    $browser = 'Chrome';
                } elseif (preg_match('/firefox/i', $userAgent)) {
                    $browser = 'Firefox';
                } elseif (preg_match('/safari/i', $userAgent)) {
                    $browser = 'Safari';
                } elseif (preg_match('/msie|trident/i', $userAgent)) {
                    $browser = 'Internet Explorer';
                }
            }

            $userId = null;
            $isAdminLog = false;
            $adminEmail = null;
            $adminId = null;

            if ($user instanceof \App\Models\User) {
                $userId = $user->id;
                $description = "User performed request: {$request->method()} {$request->fullUrl()}";
            } elseif ($user instanceof \App\Models\Admin) {
                $isAdminLog = true;
                $adminEmail = $user->email;
                $adminId = $user->id;
                $description = "Admin ($adminEmail) performed request: {$request->method()} {$request->fullUrl()}";
            } else {
                $description = "Authenticated user performed request: {$request->method()} {$request->fullUrl()}";
            }

            UserLog::create([
                'user_id' => $userId,
                'action' => $request->route() ? ($request->route()->getName() ?: $action) : $action,
                'module' => $module,
                'description' => $description,
                'ip_address' => $request->ip(),
                'user_agent' => $userAgent,
                'device_type' => $deviceType,
                'platform' => $platform,
                'browser' => $browser,
                'meta' => [
                    'input' => collect($request->except(['password', 'password_confirmation', 'token']))
                        ->map(function ($value) {
                            if (is_scalar($value) || is_array($value)) {
                                return $value;
                            }
                            if ($value instanceof \Illuminate\Http\UploadedFile) {
                                return '[File: ' . $value->getClientOriginalName() . ']';
                            }
                            if (is_object($value)) {
                                return '[Object: ' . get_class($value) . ']';
                            }
                            return '[Unknown Type]';
                        })
                        ->toArray(),
                    'status_code' => $response->getStatusCode(),
                    'is_admin' => $isAdminLog,
                    'admin_email' => $adminEmail,
                    'admin_id' => $adminId,
                    'guard' => $guardUsed,
                ],
            ]);
        }

        return $response;
    }
}
