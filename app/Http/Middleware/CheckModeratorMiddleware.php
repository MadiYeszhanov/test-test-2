<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckModeratorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->role->id == 2){
            return $next($request);
        }

        return response()->json([
            'Forbidden'
        ], 403);
    }
}
