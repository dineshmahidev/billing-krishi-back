<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventDemoMutations
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && (bool) $user->is_demo) {
            $method = strtoupper($request->method());

            // Allow safe read-only methods: GET, HEAD, OPTIONS
            if (in_array($method, ['GET', 'HEAD', 'OPTIONS'])) {
                return $next($request);
            }

            // Allow essential non-mutating POST actions (logout and PDF generation)
            $path = trim($request->path(), '/');
            $allowedPaths = [
                'api/logout',
                'api/group-summary/pdf',
                'api/bulk-settlement/pdf',
            ];

            if (in_array($path, $allowedPaths)) {
                return $next($request);
            }

            return response()->json([
                'message' => 'Demo Access is Read-Only. Creating, modifying, or deleting records is disabled for demo accounts.',
                'error' => 'demo_read_only'
            ], 403);
        }

        return $next($request);
    }
}
