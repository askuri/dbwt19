<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mahlzeit extends Model
{
    protected $table = 'Mahlzeiten';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    public function prices(){
        return $this->hasMany('App\Preis', 'MahlzeitenID');
    }

    public function priceYear(){
        return $this->prices()->where('Jahr', date("Y"));
    }
    public function comments()
    {
        return $this->hasMany('App\Kommentar', 'MahlzeitenID');
    }

    public function pictures()
    {
        return $this->belongsToMany('App\Bild',
            'MahlzeitenHatBilder',
            'MID',
            'BID');
    }


    public function ingredients()
    {
        return $this->belongsToMany('App\Zutat',
            'MahlzeitenEnthältZutaten',
            'MID',
            'ZID');
    }
}
