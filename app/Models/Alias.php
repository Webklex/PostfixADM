<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alias extends Model {

    protected $table = '';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'super_user'
    ];


    public function domain(){
        return $this->belongsTo(Domain::class);
    }

}
