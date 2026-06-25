<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            \App\Models\Visit::create([
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'page' => $request->path()
            ]);
        } catch (\Exception $e) {
            // Log do erro silencioso
            \Illuminate\Support\Facades\Log::error('Erro ao registar visita: ' . $e->getMessage());
        }

        return $next($request);
    }
}
