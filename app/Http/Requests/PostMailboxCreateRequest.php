<?php

namespace App\Http\Requests;

class PostMailboxCreateRequest extends Request {

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
            'domain_id'  => 'required|integer',
            'email'      => 'required|string',
            'password'   => 'required|string',
            'quota_kb'   => 'required|integer'
        ];
    }
}
