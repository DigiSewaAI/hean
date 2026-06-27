<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocaleMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // यदि session मा locale छ भने सेट गर
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        }
        // वा request बाट locale लिन (वैकल्पिक)
        else if ($request->has('locale')) {
            $locale = $request->get('locale');
            if (in_array($locale, ['en', 'ne'])) {
                App::setLocale($locale);
                Session::put('locale', $locale);
            }
        }

        return $next($request);
    }
}