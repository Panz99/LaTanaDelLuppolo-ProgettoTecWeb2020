<?php
    require_once 'htmlMaker.php';
    require_once 'dbConnection.php';
    session_start();
    //controllo se minorenne
    if(!isset($_SESSION['adult']) || !$_SESSION['adult'])
        header('Location: ageverification.php');
    
    
    $paginaHTML = file_get_contents('../html/registrazione.html');
    $paginaHTML = str_replace("<head/>", htmlMaker::makeHead("Registrati - La tana del Luppolo"), $paginaHTML);
    $paginaHTML = str_replace("<keywords/>", ", account, registrazione", $paginaHTML); 
    $paginaHTML = str_replace("<header/>", htmlMaker::makeHeader(), $paginaHTML);
    $paginaHTML = str_replace("<tornasu/>", htmlMaker::makeTornaSu(), $paginaHTML);
    $paginaHTML = str_replace("<footer/>", htmlMaker::makeFooter(), $paginaHTML);

    $Errore="";
    //controllo se loggato
    if(isset($_SESSION['id'])){
        //Prima di registrarti devi effettuare il logout dal tuo account
    }else{
        if(isset($_SESSION['Registrati'])){
            //ha inviato dei dati quindi controllo se sono validi e in caso positivo li invio al db, se tutto va bene accede e va a dettagli_account
        }

        //Costruisco la pagina normalmente
    } 

    $paginaHTML = ($Errore) ? str_replace("<error/>", $Errore, $paginaHTML) : str_replace("<error/>", "", $paginaHTML);
    $paginaHTML = str_replace("<root/>", "../", $paginaHTML);
    echo $paginaHTML;
?>