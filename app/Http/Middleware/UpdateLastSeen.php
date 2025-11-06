<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ActiveUser;
use Illuminate\Support\Facades\Auth;

class UpdateLastSeen
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            ActiveUser::updateOrCreate(
                ['user_id' => Auth::id()],
                ['last_seen' => now()]
            );
        }

        return $next($request);
    }
}
