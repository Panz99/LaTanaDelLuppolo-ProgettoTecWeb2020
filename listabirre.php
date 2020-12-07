<?php
require_once 'dbConnection.php';
#PROVA CONNESSIONE
#Andrebbe implementato un try catch nella classe che lancia una nuova pagina html con l'errore nel caso in cui la connessione fallisce
$dbAccess = new DBAccess();
try {
    $esitoConnessione = $dbAccess->openDBConnection(); 
    $listaBirre = $dbAccess->getListaBirre();
    //Creo la parte di pagina HTML con elenco delle birre
    $htmlListaBirre = '<div class="container">';
    foreach ($listaBirre as $birra) {
        $htmlListaBirre .= '<div class="prodotto" onclick="dettagli()"><h2>' . $birra['nome'] . '</h2>';     
        $htmlListaBirre .= '<img class="img_prod" src="'.$birra['img_path'].'"/>';
        $htmlListaBirre .= '<p class="dettagli"><span>' . $birra['tipo'] . ' | </span>'; 
        $htmlListaBirre .= '<span>Costo: ' . $birra['costo'] . ' | ' . '</span>';   
        $htmlListaBirre .= '<span>Grado: ' . $birra['grado'] . '</span></p></div>';
    }
    $htmlListaBirre .= '</div>';
    echo $htmlListaBirre;
    //$paginaHTML = file_get_contents('index.html');
    //echo str_replace("<listabirre/>", $htmlListaBirre, $paginaHTML);
} catch (Exception $e) {
    //Andrebbe lanciata una pagina con gli errori
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
?>
