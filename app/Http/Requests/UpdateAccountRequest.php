<?php

namespace App\Http\Requests;

class UpdateAccountRequest extends Request {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(){
        return [
            'password'      => 'required|string',
            'password_two'  => 'required|string|same:password',
        ];
    }
}
