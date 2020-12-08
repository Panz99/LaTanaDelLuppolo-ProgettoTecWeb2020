<?php
require_once 'dbConnection.php';
#PROVA CONNESSIONE
#Andrebbe implementato un try catch nella classe che lancia una nuova pagina html con l'errore nel caso in cui la connessione fallisce
$dbAccess = new DBAccess();
try {
    $esitoConnessione = $dbAccess->openDBConnection(); 
    $n_birre = $dbAccess->getNumBirre();
    $dbAccess->closeDBConnection();
    $n_pagine = ($n_birre%8==0) ? $n_birre/8 : $n_birre/8 + 1;

    //Creo la parte di pagina HTML con elenco delle birre
    $htmlListaPagine = '<ul id="list_pages">';
    //$htmlListaPagine .= '<li class="id_page" hidden onclick="loadBeers();">Precedente</li>';
    for($i=1; $i<=$n_pagine; $i++){
        $htmlListaPagine .= '<li class="page" id="'.$i.'"onclick="loadBeers(\''.$i.'\');">'.$i.'</li>';
    }
    //$htmlListaPagine .= '<li class="id_page" hidden onclick="loadBeers();">Successiva</li>';
    $htmlListaPagine.='</ul>';
    echo $htmlListaPagine;
    //$paginaHTML = file_get_contents('index.html');
    //echo str_replace("<listabirre/>", $htmlListaBirre, $paginaHTML);
} catch (Exception $e) {
    //Andrebbe lanciata una pagina con gli errori
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
?>