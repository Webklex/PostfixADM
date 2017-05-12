<?php

namespace App\Http\Controllers;

class UpdateController extends Controller {

    /**
     * Create a new controller instance.
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $currentVersion = file_get_contents(base_path('VERSION'));

        $agent= 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_VERBOSE, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, $agent);
        curl_setopt($ch, CURLOPT_URL, 'http://postfixadm-website.dev/api/version/new/'.config('postfixadm.serial_number'));
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $data = json_decode(curl_exec($ch));
        curl_close($ch);

        $nextVersion = null;
        $changelog = [];
        if($data != null){
            $nextVersion = $data->version;
            $changelog = $data->changelog;
        }

        return view('update.index', [
            'currentVersion' => $currentVersion,
            'nextVersion'    => $nextVersion,
            'changelog'      => $changelog,
        ]);
    }

    /**
     * @param $next
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function start($next){
        $currentVersion = file_get_contents(base_path('VERSION'));

        return view('update.start', [
            'currentVersion' => $currentVersion,
            'next' => $next,
        ]);
    }
}
