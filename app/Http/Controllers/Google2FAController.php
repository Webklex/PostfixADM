<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Crypt;
use PragmaRX\Google2FA\Vendor\Laravel\Facade as Google2FA;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use \ParagonIE\ConstantTime\Base32;

class Google2FAController extends Controller {

    /**
     * Create a new controller instance.
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function enableTwoFactor(Request $request){
        //generate new secret
        $secret = $this->generateSecret();

        //get user
        $user = $request->user();

        //encrypt and then save secret
        $user->google2fa_secret = Crypt::encrypt($secret);
        $user->save();

        //generate image for QR barcode
        $imageDataUri = Google2FA::getQRCodeInline(
            $request->getHttpHost(),
            $user->email,
            $secret,
            200
        );

        return view('settings.2fa.enable', [
            'image' => $imageDataUri,
            'secret' => $secret
        ]);
    }

    /**
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function disableTwoFactor(Request $request){
        $user = $request->user();

        //make secret column blank
        $user->google2fa_secret = null;
        $user->save();

        return view('settings.2fa.disable');
    }

    /**
     * Generate a secret key in Base32 format
     *
     * @return string
     */
    private function generateSecret(){
        $randomBytes = random_bytes(10);

        return Base32::encodeUpper($randomBytes);
    }
}