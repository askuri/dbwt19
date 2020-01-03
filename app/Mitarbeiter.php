<?php
namespace Emensa\Model;

class Mitarbeiter {
    public $nummer;
    public $buero;
    public $telefon;
    
    /**
     * add user to table
     */
    public function add(): int {
        // büro and telefon are optional!
        $query = "INSERT INTO Mitarbeiter
            (Nummer, Büro, Telefon)
	VALUES
            ($this->nummer, ". $this->buero ? "'".$this->buero."'" : 'NULL' .", ". $this->telefon ? "'".$this->telefon."'" : 'NULL' .");";
        
        $this->sql->query($query);
        $this->nummer = $this->sql->insert_id;
    }
}