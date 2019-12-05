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

    public static function getProductWithPicturePriceWithID($remoteConnection, $id){
        $query = 'SELECT m.Beschreibung, m.Name, b.`Alt-Text`, b.Binärdaten, p.Studentpreis, p.Gastpreis, p.`MA-Preis` FROM Mahlzeiten m 
                  LEFT JOIN MahlzeitenHatBilder mhb ON m.ID = mhb.`MID` 
                  LEFT JOIN Bilder b ON mhb.BID = b.ID 
                  JOIN Preise p ON m.ID = p.ID 
	              WHERE p.Jahr = YEAR(NOW()) 
                  AND m.ID = '.$id.';'; //SQL Injection

        if (!($result = mysqli_query($remoteConnection, $query))) {
            var_dump(mysqli_error($remoteConnection));
            die('Query konnte nicht ausgeführt werden: Mahlzeiten');
        }

        $product = mysqli_fetch_assoc($result);
        if($product == NULL){
            return NULL;
        }
        $pic = new namespace\Bild(NULL, $product['Alt-Text'], NULL, $product['Binärdaten']);
        $price = new namespace\Preis(NULL, NULL, NULL,
            $product['Gastpreis'],$product['Studentpreis'],$product['MA-Preis']);
        $product = new namespace\Mahlzeit(NULL, NULL,
            $product['Name'], $product['Beschreibung'], NULL);
        return new MahlzeitInfo($product, $pic, $price);

    }

}