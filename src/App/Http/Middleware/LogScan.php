<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogScan
{
    public function handle(Request $request, Closure $next): Response
    {
        $request->barcode->owner->logScan();

        return $next($request);
    }
}
