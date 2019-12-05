<?php


namespace Emensa\Model;


class MahlzeitInfo
{
    var $mahlzeit;
    var $picture;
    var $price;

    /**
     * MahlzeitInfo constructor.
     * @param $mahlzeit
     * @param $picture
     * @param $price
     */
    public function __construct($mahlzeit, $picture, $price)
    {
        $this->mahlzeit = $mahlzeit;
        $this->picture = $picture;
        $this->price = $price;
    }

}