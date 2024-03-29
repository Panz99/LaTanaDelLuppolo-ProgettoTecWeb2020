<?php
class DBAccess
{
    private const HOST_DB = "localhost";
    private const USERNAME = "root";
    private const PASSWORD = "";
    private const DB_NAME = "birrificio_test";

    private static function openDBConnection(){
        $connection = new mysqli(DBAccess::HOST_DB, DBAccess::USERNAME, DBAccess::PASSWORD, DBAccess::DB_NAME);
        if($connection->connect_errno)
            throw new Exception("Connessione al database fallita: ". $connection->connect_error);
        mysqli_set_charset($connection,"utf8");
        return $connection;
    }
    //Utilizzato per le query che restituiscono una sola colonna, trasforma la risposta in un array monodimensionale
    private static function collapse($result) {
        if ($result != null) {
            $key = array_keys($result[0])[0];
            $new_result = [];
            $lim = count($result);
            for($i = 0; $i < $lim; $i++) {
                $new_result[$i] = $result[$i][$key];
            }
            return $new_result;
        }
        return null;
        
    }
    public static function query($query, $collapse = false) {
        $connection = self::openDBConnection();
        if(!$result = $connection->query($query)) {
            throw new Exception("Esecuzione della query (".$query.") fallita.\n Errore: " .$connection->error);
        }
        $connection->close();

        if($result->num_rows == 0)
            return null;
        $list = [];
        while($row = $result->fetch_assoc()) {
            array_push($list, $row);
        }
        $result->free();
        if ($collapse) {
            $list = self::collapse($list);
        }
        return $list;
    }

    public static function command($command) {
        $connection = self::openDBconnection();
        if(!($connection->query($command))) {
            switch ($connection->errno) {
                case '1062':
                    throw new Exception("L'utente é giá presente nel database");
                    break;
                default:
                    throw new Exception("Operazione fallita. Errore: $connection->error, codice: $connection->errno");
                    break;
            }
        }
        $connection->close();
    }
}
?>