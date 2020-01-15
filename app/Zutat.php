<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zutat extends Model
{
    protected $table = 'Zutaten';
    protected $primaryKey = 'ID';
    public $timestamps = false;


    public function ingredients()
    {
        return $this->belongsToMany('App\Mahlzeit',
            'MahlzeitenEnthältZutaten',
            'ZID',
            'MID');
    }
}
