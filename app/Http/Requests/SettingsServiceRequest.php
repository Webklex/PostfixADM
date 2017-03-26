<?php

namespace App\Http\Requests;

class SettingsServiceRequest extends Request {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(){
        return [
            'generate_new_ssl'     => '',
            'generate_new_quota'  => '',
            'encryption'        => 'required|string',
            'quota'     => '',
            'quota_url'     => '',
            'quota_token'     => '',
        ];
    }
}
