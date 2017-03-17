<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Webklex\Translator\Facades\TranslatorFacade;

class SetLanguageMiddleware {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Session::has('locale')) {
            app()->setLocale(session()->get('locale'));
            TranslatorFacade::setLocale(session()->get('locale'));
        }

        return $next($request);
    }
}
