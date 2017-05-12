<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {
    use Notifiable;

    protected $table = 'pfa_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'super_user'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'google2fa_secret'
    ];

    protected $casts = [
        'super_user' => 'boolean'
    ];

    public function domains(){
        return $this->belongsToMany(Domain::class, 'pfa_domain_user');
    }

    public function logs(){
        return $this->hasMany(Log::class);
    }
}
