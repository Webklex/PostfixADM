<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alias extends Model {
    use MappedModel;

    protected $table = 'pfa_aliases';

    protected $map = 'alias';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'domain', 'source', 'destination'
    ];

    public static function whereHasAvailableDomain(){
        $mapConfig  = collect(json_decode(env('DB_MAPPING'), true));
        $mapColumnConfig = collect($mapConfig->get('alias')['columns']);
        $config = $mapColumnConfig->get('domain');
        $attribute = $config == false ? 'domain' : $config['column'];

        if(isset($config['join'])){
            return self::whereIn($attribute, Domain::available()->pluck($config['join']['key']));
        }
        return self::whereIn($attribute, Domain::available()->pluck('name'));
    }


    public function getSourceAttribute(){
        return $this->getMapped('source');
    }

    public function setSourceAttribute($value){
        return $this->setMapped('source', $value);
    }

    public function getDestinationAttribute(){
        return $this->getMapped('destination');
    }

    public function setDestinationAttribute($value){
        return $this->setMapped('destination', $value);
    }

    public function getDomainAttribute(){
        return $this->getMapped('domain');
    }

    public function setDomainAttribute($value){
        return $this->setMapped('domain', $value);
    }
}