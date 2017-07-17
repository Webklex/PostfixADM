<?php

namespace App\Http\Controllers;

use App\Libraries\BrowserHistory\BrowserHistory;

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function welcome(){
        return view('welcome');
    }

    /**
     * Redirect to previous BrowserHistory URI
     */
    public function redirectBack(){
        /** @var BrowserHistory */
        return \BrowserHistory::back();
    }
}
