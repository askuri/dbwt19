<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class ORMBenutzer extends Model {
    protected $table = 'Benutzer';
    protected $primaryKey = 'Nummer';
    public $timestamps = false;
    
    public function kommentare()
    {
        return $this->hasMany('App\Kommentar', 'StudentenID', 'Nummer');
    }
}