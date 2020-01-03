<?php
namespace App;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Model
 *
 * @author martin
 */
class Model {
    
    protected $sql;
    
    function __construct() {
        $sql = new \mysqli(getenv('DB_HOST'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'), getenv('DB_DATABASE'), (int) getenv('DB_PORT'));
        if ($sql->errno) {
            printf("Konnte nicht zur entfernten Datenbank verbinden: %s\n", $sql->error);
            exit();
        }
        $this->sql = $sql;
    }
    
    public function getSqlErrno() {
        return $this->sql->errno;
    }
    
    public function getSqlError() {
        return $this->sql->error;
    }
    
    public function getSqlErrorList() {
        return $this->sql->error_list;
    }
    
    public function getLastInsertID() {
        return $this->sql->insert_id;
    }
}
