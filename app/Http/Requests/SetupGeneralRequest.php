<?php

namespace App\Http\Requests;

class SetupGeneralRequest extends Request {

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
            'APP_DEBUG'         => '',
            'encryption'        => 'required|string',
            'APP_LOG_LEVEL'     => 'required|string',
            'APP_URL'           => 'required|url',
            'DB_CONNECTION'     => 'required|string',
            'DB_HOST'           => 'required|string',
            'DB_PORT'           => 'required|integer',
            'DB_DATABASE'       => 'required|string',
            'DB_USERNAME'       => 'required|string',
            'DB_PASSWORD'       => 'required|string',
            'MAIL_DRIVER'       => 'required|string',
            'MAIL_HOST'         => 'required|string',
            'MAIL_PORT'         => 'required|integer',
            'MAIL_USERNAME'     => 'required|string',
            'MAIL_PASSWORD'     => 'required|string',
            'MAIL_ENCRYPTION'   => 'required|string'
        ];
    }
}
