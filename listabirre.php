<?php
require_once 'dbConnection.php';
#PROVA CONNESSIONE
$dbAccess = new DBAccess();
try {
    $esitoConnessione = $dbAccess->openDBConnection(); 
    $listaBirre = $dbAccess->getListaBirre();
    //Creo la parte di pagina HTML con elenco delle birre
    $htmlListaBirre = '<dl id="listabirre">';
    foreach ($listaBirre as $birra) {
        $htmlListaBirre .= '<dt>Nome: </dt><dd>' . $birra['nome'] . '</dd>';     
        $htmlListaBirre .= '<dt>Tipo: </dt><dd>' . $birra['tipo'] . '</dd>';
        $htmlListaBirre .= '<dt>Costo: </dt><dd>' . $birra['costo'] . '</dd>';
        $htmlListaBirre .= '<dt>Grado: </dt><dd>' . $birra['grado'] . '</dd>';
        $htmlListaBirre .= '<dt>Descrizione: </dt><dd>' . $birra['descrizione'] . '</dd>';
    }
    $htmlListaBirre .= '</dl>';
    $paginaHTML = file_get_contents('birre.html');
    echo str_replace("<listabirre/>", $htmlListaBirre, $paginaHTML);
} catch (Exception $e) {
    //Andrebbe lanciata una pagina con gli errori
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
?>
