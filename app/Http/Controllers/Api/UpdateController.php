<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Log;
use Chumper\Zipper\Facades\Zipper;
use Illuminate\Support\Facades\Artisan;

class UpdateController extends Controller {

    /**
     * Create a new controller instance.
     */
    public function __construct() {}

    /**
     * @param $step
     * @param $version
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function performStep($step, $version){
        $status = false;
        $error = [];
        $warning = [];

        $mirror = config('app.update_mirror');

        switch($step){
            case 'connect':
                if($this->getCurlRequest($mirror.'/version/new/'.config('postfixadm.serial_number')) != null){
                    $status = true;
                }else{
                    $warning[] = _t('Update server currently not available.');
                }

                if(is_writable(storage_path('patches')) == false){
                    $status = false;
                    $error[] = storage_path('patches');
                }
                break;
            case 'download':
                $url = $mirror.'/version/new/download';
                $data = $this->postCurlRequest($url, [
                    'version'     => $version,
                    'serial'      => config('postfixadm.serial_number'),
                    'public_key'  => base64_encode(config('postfixadm.encryption.public_key')),
                ]);
                if($data != null){

                    $version   = $data->version;
                    $content   = base64_decode($data->content);
                    $patchFile = storage_path('patches/'.$version.'.patch');

                    openssl_private_decrypt(hex2bin($data->hash), $hash, config('postfixadm.encryption.private_key'));

                    file_put_contents($patchFile, $content);

                    $hashTest = hash_file('sha256', $patchFile);
                    $status = ($hashTest == $hash);
                }else{
                    $warning[] = _t('Patch file download failed.');
                }
                break;
            case 'extract':
                $patchPath = storage_path('patches/');
                $patchFile = $patchPath.$version.'.patch';

                if(file_exists($patchFile)){
                    Zipper::make($patchFile)->extractTo($patchPath.$version);

                    if(is_dir($patchPath.$version) && count(recursive_glob($patchPath.$version)) > 0){
                        $status = true;
                    }
                }
                break;
            case 'applied':
                $patchPath = storage_path('patches/'.$version);
                $patchFiles = recursive_glob($patchPath);


                foreach($patchFiles as $patchFile){
                    $file = str_replace($patchPath, base_path(), $patchFile);
                    $root = dirname($file);

                    if(is_dir($root) == true){
                        if(is_writable($root) == false){
                            $error[] = $root;
                        }
                    }

                    if(file_exists($file) == true){
                        if(is_writable($file) == false){
                            $error[] = $file;
                        }
                    }
                }

                if(count($error) == 0){
                    foreach($patchFiles as $patchFile){
                        $file = str_replace($patchPath, base_path(), $patchFile);
                        $root = dirname($file);

                        if(is_dir($root) == false){
                            mkdir($root, 0777, true);
                        }

                        file_put_contents($file, file_get_contents($patchFile));
                    }

                    $status = true;
                }

                break;
            case 'migration':
                Artisan::call('migrate');
                $status = true;
                break;
            case 'completed':

                Log::log('System updated');
                $status = true;
                break;
        }

        return response()->json([
            'status' => $status,
            'error'  => $error,
            'warning'  => $warning,
        ]);
    }

    /**
     * @param $url
     * @return mixed
     */
    protected function getCurlRequest($url){
        $agent= 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_VERBOSE, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, $agent);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $data = json_decode(curl_exec($ch));
        curl_close($ch);

        return $data;
    }

    /**
     * @param $url
     * @param array $payload
     *
     * @return mixed
     */
    protected function postCurlRequest($url, array $payload = []){
        $payload_string = '';
        foreach($payload as $key => $value) { $payload_string .= $key.'='.$value.'&'; }
        rtrim($payload_string, '&');
        $agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_VERBOSE, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, $agent);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch,CURLOPT_POST, count($payload));
        curl_setopt($ch,CURLOPT_POSTFIELDS, $payload_string);

        $data = json_decode(curl_exec($ch));

        curl_close($ch);

        return $data;
    }
}