<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bild extends Model
{
    protected $table = 'Bilder';
    protected $primaryKey = 'ID';
    public $timestamps = false;


    public function pictures()
    {
        return $this->belongsToMany('App\Mahlzeit',
            'MahlzeitenHatBilder',
            'BID',
            'MID');
    }
}
