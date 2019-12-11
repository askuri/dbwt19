<?php


namespace Emensa\Controller;

require_once './inc/PHPprepare.php';
require_once './models/Mahlzeit.php';
require_once './models/Zutat.php';
require_once './models/Bild.php';
require_once './models/Preis.php';
require_once './models/MahlzeitInfo.php';
use Emensa\Model\Mahlzeit;
use Emensa\Model\Zutat;


class DetailController
{

    public function getView($productID, $userType){
        $remoteConnection = connectToDB();
        $productWithInfo = \Emensa\Model\Mahlzeit::getProductWithPicturePriceWithID($remoteConnection, $productID);

        //Query For Mahlzeit
        if ($productWithInfo === NULL) {
            //Redirect if product id invalid
            header('location: Produkte.php');
        }
        $priceForUser = NULL;
        if ($userType == 'Student') {
            $user_price_category = 'Studentpreis';
            $priceForUser = $productWithInfo->price->Studentenpreis;
        } else if ($userType == 'Gast') {
            $user_price_category = 'Gastpreis';
            $priceForUser = $productWithInfo->price->Gastpreis;
        } else {
            $user_price_category = 'MA-Preis';
            $priceForUser = $productWithInfo->price->MAPreis;
        }

        //Get zutaten
        $zutaten = Zutat::getAllForProduct($remoteConnection, $productID);
        $remoteConnection->close();

        global $blade;
        return $blade->run("detail.Detail", [
            'product' => $productWithInfo->mahlzeit,
            'picture' => $productWithInfo->picture,
            'productPrice' => $priceForUser,
            'zutaten' => $zutaten,
            'user_price_category' => $user_price_category
        ]);
    }
}
