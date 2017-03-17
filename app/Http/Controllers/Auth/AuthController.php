<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller {

    /**
     * Create a new controller instance.
     *
     */
    public function __construct(){

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        Auth::logout();

        return redirect()->to('/');
    }

    /**
     * Change the current language
     *
     * @param string $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeLanguage($locale){
        if(in_array($locale, config('translator.available'))){
            Session::put('locale', $locale);
            Session::save();
            app()->setLocale($locale);
        }

        return redirect()->back();
    }
}
