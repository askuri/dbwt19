<?php
namespace Emensa\Controller;

use Emensa\Model\Mahlzeit;

require_once './inc/PHPprepare.php';
require_once './models/Mahlzeit.php';
require_once './models/Bild.php';
require_once './models/Kategorie.php';
use \Emensa\Model\Kategorie;

class ProdukteController{

    private function getProducts($remoteConnection, $onlyAvail, $onlyVegan, $onlyVeget, $onlyProductsOfCategory,$limit){
        //TODO import laravel and clean up this mess
        $query = 'SELECT m.ID AS MID, m.Beschreibung, m.Vorrat, b.ID AS BID, b.`Alt-Text`, b.Binärdaten, m.Name FROM Mahlzeiten m
                  LEFT JOIN MahlzeitenHatBilder mhb ON m.ID = mhb.`MID`
                  LEFT JOIN Bilder b ON mhb.BID = b.ID ';
        if ($onlyAvail || $onlyVegan || $onlyVeget || $onlyProductsOfCategory){
            $query .= ' WHERE ';
        }
        $needsLogicalOperator = false;

        if ($onlyAvail) {
            $query .= 'Vorrat > 0 ';
            $needsLogicalOperator = true;
        }

        if ($onlyVeget) {
            if($needsLogicalOperator){
                $query .= 'AND ';
            }
            //Mahlzeiten having no ingredients are also vegetarian...
            $query .= 'TRUE = ALL ( SELECT z.Vegetarisch FROM Zutaten z
               JOIN MahlzeitenEnthältZutaten mEz on mEz.ZID = z.ID
               WHERE mEz.MID = m.ID) ';

            $needsLogicalOperator = true;
        }

        if ($onlyVegan) {
            if($needsLogicalOperator){
                $query .= 'AND ';
            }
            //Mahlzeiten having no ingredients are also vegan...
            $query .= ' TRUE = ALL(SELECT z.Vegan FROM Zutaten z
               JOIN MahlzeitenEnthältZutaten mEz on mEz.ZID = z.ID
               WHERE mEz.MID = m.ID) ';

            $needsLogicalOperator = true;
        }

        if($onlyProductsOfCategory){
            if($needsLogicalOperator){
                $query.= 'AND ';
            }
            $query .= 'm.KategorieID = '.$onlyProductsOfCategory.' ';

            $needsLogicalOperator = true;
        }

        if ($limit) {
            $query .= ' LIMIT '.$limit;
        }

        if (!($result = mysqli_query($remoteConnection, $query))) {
            echo mysqli_error($remoteConnection);
            die('Query konnte nicht ausgeführt werden');
        }

        $productList = [];
        $pictureList = [];
        while($row = mysqli_fetch_assoc($result)){
            $productList +=
                [$row['MID'] =>
                    new \Emensa\Model\Mahlzeit($row['MID'], NULL,$row['Name'], $row['Beschreibung'], $row['Vorrat'])];

            $pictureList +=
                [$row['MID'] =>
                    new \Emensa\Model\Bild($row['BID'],$row['Alt-Text'], NULL,$row['Binärdaten'])];
        }
        return array($productList, $pictureList);
    }

    public function getView($onlyAvail, $onlyVegan, $onlyVeget, $onlyProductsOfCategory,$limit){
        $remoteConnection = connectToDB();
        list($productResults, $pictureResults) = $this->getProducts($remoteConnection, $onlyAvail, $onlyVegan, $onlyVeget, $onlyProductsOfCategory,$limit);
        $categoryResults = \Emensa\Model\Kategorie::getAllCategoriesOrderedHierarchical($remoteConnection);

        $selectedCategoryName = 'Bestseller';
        if($onlyProductsOfCategory){
            foreach($categoryResults as $category){
                if($category->ID == $onlyProductsOfCategory){
                    $selectedCategoryName = $category->Bezeichnung;
                }
            }
        }

        if(count($productResults) == 0){
            $selectedCategoryName = 'Keine Ergebnisse';
        }
        $remoteConnection->close();
        global $blade;
        return $blade->run("produkte.Produkte", [
            'mealResult' => array_chunk($productResults,4),
            'pictures' => $pictureResults,
            'categoryList' => $categoryResults,
            'selectedID' => $onlyProductsOfCategory,
            'selectedCategoryName' => $selectedCategoryName,
            'isOnlyAvailableSelected' => $onlyAvail,
            'isVegetSelected' => $onlyVeget,
            'isVeganSelected' => $onlyVegan
        ]);
    }
}
