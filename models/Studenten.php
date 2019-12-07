<?php
namespace Emensa\Model;

class Studenten extends Model {
    public $nummer;
    public $studiengang;
    public $matrikelnummer;
    
    /**
     * add user to table
     */
    public function add() {
        $query = "INSERT INTO Studenten
            (Nummer, Studiengang, Matrikelnummer)
	VALUES
            ($this->nummer, '$this->studiengang', $this->matrikelnummer);";
        
        $this->sql->query($query);
        $this->nummer = $this->sql->insert_id;
    }
    
    public function getStudiengaenge() {
        $query = "SELECT SUBSTRING(COLUMN_TYPE,5) as Studiengaenge
            FROM information_schema.COLUMNS
            WHERE TABLE_NAME='Studenten'
                AND COLUMN_NAME='Studiengang'";
        $result = $this->sql->query($query);
        $raw = $result->fetch_assoc()['Studiengaenge'];
        $raw = trim($raw, '(');
        $raw = trim($raw, ')');
        $raw = str_replace('\'', '', $raw);
        return explode(',', $raw);
    }
}