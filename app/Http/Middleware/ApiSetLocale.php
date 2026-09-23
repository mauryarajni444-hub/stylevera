<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

/**
 * Sets the application locale for API requests based on the
 * Accept-Language header sent by the Flutter app ('en' or 'ar').
 * This lets Product/Category/Banner models' nameLocale()/descLocale()
 * helpers return Arabic content, mirroring the website's session-based
 * locale switch.
 */
class ApiSetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $lang = $request->header('Accept-Language', 'en');
        $lang = str_starts_with($lang, 'ar') ? 'ar' : 'en';
        App::setLocale($lang);

        return $next($request);
    }
}
