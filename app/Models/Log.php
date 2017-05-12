<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model {

    protected $table = 'pfa_logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'message'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public static function log($message){

        /** @var self $mLog */
        $mLog = self::create(['message' => $message]);
        $mLog->user()->associate(auth()->user()->id);
        $mLog->save();

        return $mLog;
    }

}