<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TokenAuth
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('Authorization');

        if (!$token) {
            return response()->json([
                'message' => 'Token is missing',
            ], 400);
        }

        $user = Auth::guard('api')->onceUsingId(1);

        if (!$user || $user->api_token != $token) {
            return response()->json([
                'message' => 'Token is invalid',
            ], 401);
        }

        return $next($request);
    }
}
