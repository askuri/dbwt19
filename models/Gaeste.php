<?php
namespace Emensa\Model;
require_once './models/Model.php';

class Geaste extends Model {
    public $nummer;
    public $grund;
    public $ablaufdatum;
    
    /**
     * add user to table
     */
    public function add() {
        $query = "INSERT INTO Gäste
            (Nummer, `Grund`, Ablaufdatum)
	VALUES
            ($this->nummer, '$this->grund', '$this->ablaufdatum');";
        
        $this->sql->query($query);
        $this->nummer = $this->sql->insert_id;
    }
}