<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Visitor;

class TrackVisitor
{
    public function handle(Request $request, Closure $next)
    {
        Visitor::create([
            'ip_address' => $request->ip(),
        ]);

        return $next($request);
    }
}
