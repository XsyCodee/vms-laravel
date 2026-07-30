<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class InjectCsrfToken
{
    public function handle(Request $request, Closure $next)
    {
        // Force session to start BEFORE Filament renders
        // This ensures csrf_token() works inside Livewire components
        $session = $request->session();

        // Force CSRF token generation
        if (!$session->has('_token')) {
            $session->regenerateToken();
        }

        return $next($request);
    }
}
