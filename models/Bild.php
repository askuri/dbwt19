<?php
namespace Emensa\Model;


class Bild
{
    var $ID;
    var $AltText;
    var $Titel;
    var $Binärdaten;

    /**
     * Bild constructor.
     * @param $ID
     * @param $AltText
     * @param $Titel
     * @param $Binärdaten
     */
    public function __construct($ID, $AltText, $Titel, $Binärdaten)
    {
        $this->ID = $ID;
        $this->AltText = $AltText;
        $this->Titel = $Titel;
        $this->Binärdaten = $Binärdaten;
    }

    public static function errorPic(){
        return new namespace\Bild(-1, 'No Picture found', 'No Picture found',NULL);
    }

}