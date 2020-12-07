<?php
class DBAccess
{
    private const HOST_DB = "localhost";
    private const USERNAME = "root";
    private const PASSWORD = "";
    private const DB_NAME = "birrificio_test";

    private $connection;

    public function openDBConnection(){
        $this->connection = mysqli_connect(DBAccess::HOST_DB, DBAccess::USERNAME, DBAccess::PASSWORD, DBAccess::DB_NAME);
        if(mysqli_connect_errno($this->connection))
            throw new Exception("Err: Connessione al database fallita");
    }
    public function getListaBirre() {
        $querySelect = "SELECT * FROM birre";
        $queryResult = mysqli_query($this->connection, $querySelect);
        if(mysqli_num_rows($queryResult)==0)
            throw new Exception("Err: Risultato nullo");

        $listaBirre = array();
        while($riga = mysqli_fetch_assoc($queryResult)){
            $birra = array(
                "id"=>$riga['id'],
                "nome" => $riga['nome'],
                "img_path" => $riga['img_path'],
                "tipo" => $riga['tipo'],
                "grado" => $riga['grado'],
                "descrizione" => $riga['descrizione'],
                "costo" => $riga['costo']
            );
            array_push($listaBirre, $birra);
        }
        return $listaBirre;
    }
}
?>