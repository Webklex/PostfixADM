<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingsServiceRequest;
use App\Models\Log;
use Illuminate\Support\Facades\File;

class SettingsController extends Controller {

    /**
     * Create a new controller instance.
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUpdate(){
        return view('settings.update', [
            'config' => config('postfixadm'),
            'version' => file_get_contents(base_path('VERSION'))
        ]);
    }

    /**
     * @param SettingsServiceRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function postUpdate(SettingsServiceRequest $request){
        $config = config('postfixadm');

        if($request->get('generate_new_ssl') == true){

            // Configuration settings for the key
            $options = array(
                "digest_alg" => "sha512",
                "private_key_bits" => 4096,
                "private_key_type" => OPENSSL_KEYTYPE_RSA,
            );

            // Create the private and public key
            $res = openssl_pkey_new($options);

            // Extract the private key into $private_key
            openssl_pkey_export($res, $private_key);

            // Extract the public key into $public_key
            $public_key = openssl_pkey_get_details($res);
            $public_key = $public_key["key"];

            $config['encryption'] = [
                'private_key' => $private_key,
                'public_key'  => $public_key,
            ];
        };

        $config['quota'] = [
            'enabled' => $request->get('quota') == true,
            'url'     => $request->get('quota_url'),
            'token'   => $request->get('quota_token')
        ];
        $config['encryption']['method'] = $request->get('encryption');

        if($request->get('generate_new_quota') == true) $config['quota']['token'] = str_random(32);

        ob_start();
        var_export($config);
        $content = ob_get_contents();
        ob_end_clean();
        File::put(config_path().'/postfixadm.php', "<?php\nreturn ".$content.';');
        Log::log('System settings updated');

        return view('settings.update', [
            'config' => $config,
            'updated' => true,
            'version' => file_get_contents(base_path('VERSION'))
        ]);
    }
}