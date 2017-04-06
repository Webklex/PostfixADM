<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class InstallerMiddleware
{
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
        if (file_exists(base_path().'/installer.lock') && env('INSTALLED')) {
            $parts = explode('/', substr($request->getPathInfo(), 1));
            if(count($parts) > 0){
                if(in_array($parts[0], ['language', 'installer'])){
                    return $next($request);
                }
            }
            return redirect('/installer');
        }

        return $next($request);
    }
}
