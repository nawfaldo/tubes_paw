<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserGroup
{
    public function handle(Request $request, Closure $next, ...$groups)
    {
        $user = Auth::user();

        if (! $user || ! in_array($user->usergroup->name, $groups)) {
            abort(403, 'Unauthorized access');
        }

        return $next($request);
    }
}
