<?php
namespace Emensa\Model;
require_once './inc/PHPprepare.php';


class Kategorie
{
    var $ID;
    var $BilderID = NULL;
    var $Bezeichnung;
    var $hat = NULL;

    public static function getAllCategoriesOrderedHierarchical($remoteConnection){
        $category_query = 'SELECT k.ID, k.Bezeichnung, k.hat FROM Kategorien k
                           ORDER BY CASE WHEN k.hat IS NULL THEN k.ID ELSE k.hat END, k.hat;';
        if (!($category_result = mysqli_query($remoteConnection, $category_query))) {
            echo mysqli_error($remoteConnection);
            die('Query konnte nicht ausgeführt werden');
        }

        $categoryList = [];
        while ($row = $category_result->fetch_object('\Emensa\Model\Kategorie')) {
            array_push($categoryList, $row);
        }

        $category_result->close();
        return $categoryList;
    }
}