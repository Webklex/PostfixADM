<?php
/*
* File: BrowserHistoryMiddleware.php
* Category: Middleware
* Author: MSG
* Created: 17.07.17 19:46
* Updated: -
*
* Description:
*  -
*/


namespace App\Http\Middleware;

use App\Libraries\BrowserHistory\BrowserHistory;
use Closure;

class BrowserHistoryMiddleware {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null) {

        if($request->isMethod('GET') == true){
            /** @var BrowserHistory */
            \BrowserHistory::setRequest($request)->addURI($request->getRequestUri());
        }

        return $next($request);
    }
}
