<?php

namespace App\Http\Requests;

class SetupServiceRequest extends Request {

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
            'name'      => 'required|string',
            'email'     => 'required|email',
            'password'  => 'required|string',
            'quota'     => '',
            'quota_url'     => '',
            'quota_token'     => '',
        ];
    }
}
