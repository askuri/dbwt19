<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

global $sql;
$sql = new \mysqli( getenv('DB_HOST'), getenv('DB_USER'), getenv('DB_PASS'), getenv('DB_NAME'), (int) getenv('DB_PORT') );
if ($sql->errno) {
    printf("Konnte nicht zur entfernten Datenbank verbinden: %s\n", $sql->error);
    exit();
}