<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TokenRefresh
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        
        if (auth()->check()) {
            $user = auth()->user();
            $token = $user->currentAccessToken();

            // Perbarui waktu kedaluwarsa token
            $token->forceFill([
                'last_used_at' => now(),
                'expires_at' => $token->freshTimestamp()->addMinutes(config('sanctum.expiration')),
            ])->save();
        }

        return $response;        
    }
}
