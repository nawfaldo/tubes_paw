<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!$request->user() || !$request->user()->tokenCan($role)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Akses ditolak'
            ], 403);
        }

        return $next($request);
    }
} 