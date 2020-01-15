<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Preis extends Model
{
    protected $table = 'Preise';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    public function mahlzeit(){
        return $this->belongsTo('App\Mahlzeit', 'MahlzeitenID', 'ID');
    }
}
