<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

trait MappedModel {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $mapConfig = [];
    protected $mapColumnConfig = [];

    public function __construct(array $attributes = []) {
        $this->mapConfig  = collect(json_decode(env('DB_MAPPING'), true));
        $this->mapColumnConfig = collect($this->mapConfig->get($this->map)['columns']);

        if($this->mapConfig[$this->map]['table'] != null) $this->setTable($this->mapConfig[$this->map]['table']);
        parent::__construct($attributes);
    }

    protected function getMapped($column){
        $config = $this->mapColumnConfig->get($column);
        if(isset($config['join'])){
            $join = $config['join'];
            $relation = DB::table($this->table)
                ->where($this->table.'.id', '=', $this->attributes['id'])
                ->join($join['table'], $this->table.'.'.$config['column'], $join['table'].'.'.$join['key'])
                ->select($join['table'].'.'.$join['value'])->first();

            if($relation != null){
                return $relation->{$join['value']};
            }
            return null;
        }

        $attribute = $this->mapColumnConfig->get($column) == false ? $column : $this->mapColumnConfig->get($column)['column'];

        return $this->attributes[$attribute];
    }

    protected function setMapped($column, $value){
        $config = $this->mapColumnConfig->get($column);
        $attribute = $this->mapColumnConfig->get($column) == false ? $column : $this->mapColumnConfig->get($column)['column'];
        if(isset($config['join'])){
            $join = $config['join'];
            $relation = DB::table($join['table'])
                ->where($join['table'].'.'.$join['value'], '=', $value)->first();

            if($relation != null){
                $this->attributes[$attribute] = $relation->{$join['key']};
            }
        }else{
            $this->attributes[$attribute] = $value;
        }

        return $this;

    }

    public function whereMapped($column, $values){
        if(is_array($values)){

            $config = $this->mapColumnConfig->get($column);
            if(isset($config['join'])){

            }
        }else{

        }
        $config = $this->mapColumnConfig->get($column);
        if(isset($config['join'])){

        }
    }
}