<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model {
    protected $table = 'Studenten';
    protected $primaryKey = 'Nummer';
    public $timestamps = false;
    
    public function kommentare()
    {
        return $this->hasMany('App\Kommentar', 'StudentenID', 'Nummer');
    }
}