<?php


namespace Emensa\Model;


class Preis
{
    var $ID;
    var $MahlzeitenID;
    var $Jahr;
    var $Gastpreis;
    var $Studentenpreis;
    var $MAPreis;

    /**
     * Preis constructor.
     * @param $ID
     * @param $MahlzeitenID
     * @param $Jahr
     * @param $Gastpreis
     * @param $Studentenpreis
     * @param $MAPreis
     */
    public function __construct($ID, $MahlzeitenID, $Jahr, $Gastpreis, $Studentenpreis, $MAPreis)
    {
        $this->ID = $ID;
        $this->MahlzeitenID = $MahlzeitenID;
        $this->Jahr = $Jahr;
        $this->Gastpreis = $Gastpreis;
        $this->Studentenpreis = $Studentenpreis;
        $this->MAPreis = $MAPreis;
    }

}