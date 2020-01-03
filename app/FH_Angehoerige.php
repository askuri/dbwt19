<?php
namespace Emensa\Model;

class FH_Angehoerige extends Model {
    public $nummer;
    public $fachebereichIDs = [];
    
    /**
     * add user to table
     */
    public function add() {
        $query = "INSERT INTO `FH Angehörige`
            (Nummer)
	VALUES
            ($this->nummer);";
        $this->sql->query($query);
        
        foreach ($this->fachebereichIDs as $fbid) {
            $query = "INSERT INTO `FH AngehörigeGehörtZuFachbereiche`
                (`AngehörigenID`, FbID)
            VALUES
                ($this->nummer, $fbid);";
            $this->sql->query($query);
        }
    }
}