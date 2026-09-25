<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Support\DemoContext;
use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class ResolveDemoContext
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken()
            ?: $request->query('token')
            ?: $request->input('token');

        $user = null;
        if ($token) {
            try {
                $user = PersonalAccessToken::findToken($token)?->tokenable;
            } catch (\Throwable $e) {
                $user = null;
            }
        }

        app()->instance(DemoContext::class, new DemoContext(
            $user instanceof User ? $user : null
        ));

        return $next($request);
    }
}
