<?php
namespace Emensa\Model;

class Fachbereiche extends Model {
    public $id;
    public $website;
    public $name;
    
    /**
     * add user to table
     */
    public function getAll(): array {
        $query = "SELECT * FROM Fachbereiche";
        $result = $this->sql->query($query);
        
        $result_arr = [];
        while ($row = $result->fetch_assoc()) {
            $result_arr[] = $row;
        }
        return $result_arr;
    }
}