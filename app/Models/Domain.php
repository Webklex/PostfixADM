<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Domain extends Model {
    use MappedModel;

    protected $table = 'pfa_domains';

    protected $map = 'domain';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'active'
    ];

    public function users(){
        return $this->belongsToMany(User::class, 'pfa_domain_user');
    }

    public static function availableQuery(){
        return self::whereHas('users', function($q){
            $q->where('pfa_domain_user.user_id', auth()->user()->id);
        });
    }
    public static function available(){
        return self::availableQuery()->get();
    }

    public static function getAvailable($id){
        /** @var Collection $aDomain */
        $aDomain = self::availableQuery();

        return $aDomain->find($id);
    }

    public function getNameAttribute(){
        return $this->getMapped('name');
    }

    public function setNameAttribute($value){
        return $this->setMapped('name', $value);
    }

    public function getActiveAttribute(){
        return $this->getMapped('active');
    }

    public function setActiveAttribute($value){
        return $this->setMapped('active', $value);
    }
}