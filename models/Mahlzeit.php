<?php
namespace Emensa\Model;
require_once './inc/PHPprepare.php';


class Mahlzeit
{
    var $ID;
    var $KategorieID;
    var $Name;
    var $Beschreibung;
    var $Vorrat;

    /**
     * Mahlzeit constructor.
     * @param $ID
     * @param $KategorieID
     * @param $Name
     * @param $Beschreibung
     * @param $Vorrat
     */
    public function __construct($ID, $KategorieID, $Name, $Beschreibung, $Vorrat)
    {
        $this->ID = $ID;
        $this->KategorieID = $KategorieID;
        $this->Name = $Name;
        $this->Beschreibung = $Beschreibung;
        $this->Vorrat = $Vorrat;
    }

}