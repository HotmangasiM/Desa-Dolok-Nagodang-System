<?php

namespace App\Http\Middleware;

use App\Models\VisitorLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->is('admin/*')) {
            VisitorLog::firstOrCreate([
                'ip_address' => $request->ip(),
                'url' => $request->path(),
                'visited_date' => now()->toDateString(),
            ], [
                'user_agent' => substr($request->userAgent() ?? '', 0, 255),
            ]);
        }

        return $next($request);
    }
}