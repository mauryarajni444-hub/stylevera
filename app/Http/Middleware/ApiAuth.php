<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ApiToken;

class ApiAuth
{
    public function handle(Request $request, Closure $next)
    {
        $header = $request->header('Authorization', '');
        if (!str_starts_with($header, 'Bearer ')) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $plain = substr($header, 7);
        $hashed = hash('sha256', $plain);

        $token = ApiToken::where('token', $hashed)->first();
        if (!$token) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $user = $token->user;
        if (!$user || !$user->is_active) {
            return response()->json(['message' => 'Account disabled.'], 403);
        }

        $token->update(['last_used_at' => now()]);

        $request->attributes->set('api_user', $user);
        $request->attributes->set('api_token', $token);

        return $next($request);
    }
}
