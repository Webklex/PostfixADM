<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Domain extends Model {

    protected $table = 'virtual_domains';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'active'
    ];

    public function mailboxes(){
        return $this->hasMany(Mailbox::class);
    }

    public function users(){
        return $this->belongsToMany(User::class);
    }

    public static function availableQuery(){
        return self::whereHas('users', function($q){
            $q->where('domain_user.user_id', auth()->user()->id);
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
}
