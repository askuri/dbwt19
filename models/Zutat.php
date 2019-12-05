<?php
namespace Emensa\Model {

    use mysqli;

    require_once './inc/PHPprepare.php';

    class Zutat
    {
        public $ID;
        public $Name;
        public $Bio;
        public $Vegan;
        public $Glutenfrei;
        public $Vegetarisch;

        public static function getAllForProduct($remoteConnection, $productID){
            $query = 'SELECT z.ID, z.Name, z.Bio, z.Vegan,z.Vegetarisch, z.Glutenfrei FROM Zutaten z
                      JOIN MahlzeitenEnthältZutaten mz ON mz.ZID = z.ID
                      JOIN Mahlzeiten m ON m.ID = mz.MID
                      WHERE m.ID = '.$productID.';';

            if (!($result = mysqli_query($remoteConnection, $query))) {
                mysqli_error($remoteConnection);
                die('Query konnte nicht ausgeführt werden: Zutaten');
            }
            $zutaten = [];
            while ($row = $result->fetch_object('\Emensa\Model\Zutat')) {
                $zutaten[] = $row;
            }

            $result->close();
            return $zutaten;
        }

        public static function getAll(){
            $remoteConnection = new mysqli( getenv('DB_HOST'), getenv('DB_USER'), getenv('DB_PASS'), getenv('DB_NAME'), (int) getenv('DB_PORT') );
            if (mysqli_connect_error()) {
                printf("Konnte nicht zur entfernten Datenbank verbinden: %s\n", $remoteConnection->connect_errno());
                exit();
            }

            $query = 'SELECT * FROM Zutaten ORDER BY Bio DESC;';
            $result = $remoteConnection->query($query);
            if (!($result)) {
                die('Query konnte nicht ausgeführt werden');
            }

            $mappedResult = array();
            while ($obj = $result->fetch_object('\Emensa\Model\Zutat')) {
                array_push($mappedResult, $obj);
            }

            $result->close();
            $remoteConnection->close();

            return $mappedResult;
        }

    }
}