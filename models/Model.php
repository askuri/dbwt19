<?php
namespace Emensa\Model;
require_once './inc/dbconnect.php';

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
        global $sql;
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
