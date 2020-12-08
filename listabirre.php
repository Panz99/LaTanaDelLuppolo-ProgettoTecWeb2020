<?php
require_once 'dbConnection.php';
#PROVA CONNESSIONE
#Andrebbe implementato un try catch nella classe che lancia una nuova pagina html con l'errore nel caso in cui la connessione fallisce
$start=0;
if(isset($_GET['page']))
    $start=($_GET['page']-1)*8;
$end=$start+8;
$dbAccess = new DBAccess();
try {
    $esitoConnessione = $dbAccess->openDBConnection(); 
    $listaBirre = $dbAccess->getListaBirre();
    $dbAccess->closeDBConnection();
    //Creo la parte di pagina HTML con elenco delle birre
    $htmlListaBirre = '<div id="container_beers">';
    //foreach ($listaBirre as $birra) {
    for($i=$start; $i<$end && isset($listaBirre[$i]); $i++){
        $birra=$listaBirre[$i];
        $htmlListaBirre .= '<a class="link_prodotto" href="dettagli.php?id='.$birra['id'].'">';
        $htmlListaBirre .= '<div class="prodotto"><h2>' . $birra['nome'] . '</h2>';     
        $htmlListaBirre .= '<img class="img_prodotto" src="'.$birra['img_path'].'"/>';
        $htmlListaBirre .= '<p class="dettagli"><span>' . str_replace('_', ' ', $birra['tipo']) . ' | </span>'; 
        $htmlListaBirre .= '<span>Costo: ' . $birra['costo'] . ' | ' . '</span>';   
        $htmlListaBirre .= '<span>Grado: ' . $birra['grado'] . '</span></p></div>';
    }
    $htmlListaBirre .= '</div></a>';
    echo $htmlListaBirre;
    //$paginaHTML = file_get_contents('index.html');
    //echo str_replace("<listabirre/>", $htmlListaBirre, $paginaHTML);
} catch (Exception $e) {
    //Andrebbe lanciata una pagina con gli errori
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
?>
