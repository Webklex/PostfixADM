<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mailbox extends Model {

    use MappedModel;

    protected $table = 'pfa_mailboxes';

    protected $map = 'mailbox';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'quota_kb', 'active', 'domain'
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

    public static function whereHasAvailableDomain(){
        $mapConfig  = collect(json_decode(env('DB_MAPPING'), true));
        $mapColumnConfig = collect($mapConfig->get('mailbox')['columns']);
        $config = $mapColumnConfig->get('domain');
        $attribute = $config == false ? 'domain' : $config['column'];

        if(isset($config['join'])){
            return self::whereIn($attribute, Domain::available()->pluck($config['join']['key']));
        }
        return self::whereIn($attribute, Domain::available()->pluck('name'));
    }

    public function getEmailAttribute(){
        return $this->getMapped('email');
    }

    public function setEmailAttribute($value){
        return $this->setMapped('email', $value);
    }

    public function getPasswordAttribute(){
        return $this->getMapped('password');
    }

    public function setPasswordAttribute($value){
        return $this->setMapped('password', $value);
    }

    public function getQuotaKbAttribute(){
        $value = $this->getMapped('quota_kb');
        return $value > 0 ? $value / 1024 : 0;
    }

    public function setQuotaKbAttribute($kb){
        if($kb > 0)  $kb = $kb * 1024;
        if($kb <= 0) $kb = 0;

        return $this->setMapped('quota_kb', $kb);
    }

    public function getActiveAttribute(){
        return $this->getMapped('active');
    }

    public function setActiveAttribute($value){
        return $this->setMapped('active', $value);
    }

    public function getDomainAttribute(){
        return $this->getMapped('domain');
    }

    public function setDomainAttribute($value){
        return $this->setMapped('domain', $value);
    }
}
