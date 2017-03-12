<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alias extends Model {

    protected $table = 'virtual_aliases';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'domain_id', 'source', 'destination'
    ];


    public function domain(){
        return $this->belongsTo(Domain::class);
    }

}
