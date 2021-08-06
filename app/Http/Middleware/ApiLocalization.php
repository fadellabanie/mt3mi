<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiLocalization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->header('Accept-Language');

        if (! in_array($locale, config('app.supported_languages'))) {
            $locale = app()->getLocale();
        }

        app()->setLocale($locale);

        $response = $next($request);

        $response->headers->set('Accept-Language', $locale);

        return $response;
    }
}
