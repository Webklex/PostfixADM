<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mailbox extends Model {

    protected $table = 'virtual_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'quota_kb', 'active', 'domain_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    protected $casts = [
        'active' => 'boolean'
    ];

    public function domain(){
        return $this->belongsTo(Domain::class);
    }

    public function setQuotaKbAttribute($kb){
        if($kb > 0) $this->attributes['quota_kb']= $kb * 1024;
        return $this;
    }

    public function getQuotaKbAttribute(){
        return $this->attributes['quota_kb'] > 0 ? $this->attributes['quota_kb'] / 1024 : 0;
    }

}
