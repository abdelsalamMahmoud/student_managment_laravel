<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StudentMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if(auth()->user()->role == 'student' ){
            return $next($request);
        }
        else return response()->json('you are not a student');
    }
}
