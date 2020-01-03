<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kommentar extends Model
{
    protected $table = 'Kommentare';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    public function benutzer()
    {
        return $this->belongsTo('App\ORMBenutzer', 'StudentenID', 'Nummer');
    }
}
