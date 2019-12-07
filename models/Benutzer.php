<?php
namespace Emensa\Model;
require_once './models/Model.php';

class Benutzer extends Model {
    public $nummer;
    public $email;
    public $bild = "0x0";
    public $nutzername;
    public $hash;
    public $letzterlogin; //optional
    public $anlegedatum = "NOW()";
    public $aktiv = "1";
    public $vorname;
    public $nachname;
    public $geburtsdatum; // optional
    
    
    /**
     * add user to table
     */
    public function add() {
        $query = "INSERT INTO Benutzer
            (`E-Mail`,Bild,Nutzername,Hash,LetzterLogin,Anlegedatum,Aktiv,Vorname,Nachname,Geburtsdatum)
	VALUES
            ('$this->email',$this->bild,'$this->nutzername','$this->hash',
                ". ($this->letzterlogin ? "'".$this->letzterlogin."'" : 'NULL') .",
                $this->anlegedatum,$this->aktiv,
                '$this->vorname','$this->nachname', 
                ". ($this->geburtsdatum ? "'".$this->geburtsdatum."'" : 'NULL') ." );";
        $this->sql->query($query);
        $this->nummer = $this->sql->insert_id;
    }

}