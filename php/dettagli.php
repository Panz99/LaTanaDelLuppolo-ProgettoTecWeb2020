<?php
    require_once 'dbConnection.php';
    require_once 'htmlMaker.php';
    session_start();
    //controllo se minorenne
    if(!isset($_SESSION['adult']) || !$_SESSION['adult'])
        header('Location: ageverification.php');

    //controllo se loggato
    $username = "";
    if(isset($_SESSION['id'])){
        $username = $_SESSION['id'];
    }

    $idbirra = $_GET["id"];

    //preleva info da database
    try{
        if(!$idbirra)
            throw new Exception("No id value found");

        $query = "SELECT * FROM birre WHERE id=".$idbirra;
        $birra = DBAccess::query($query)[0];

        //mostra pagina notfound se id non esiste
        if(empty($birra))
            throw new Exception("No id value found");
        
    } catch (Exception $e) {
            //Redirect a pagina errore
        header('Location: notfound.php');
    }
    // verifica se presenti parametri di inserimento/rimozione recensione solo se utente è loggato
    //eliminazione recensione
    $msg="";
    $error="";
    if(isset($_SESSION['id']) && isset($_GET['rmrev']))
    {
        //verifica che la recensione stia venendo eliminata dall'autore
        $msg="NO";
        try{
            $author=DBAccess::query("SELECT username FROM recensioni, utenti WHERE recensioni.utente=utenti.id AND recensioni.id=".$_GET['rmrev'])[0]["username"];
            if( (isset($_SESSION['admin']) && $_SESSION['admin']==1)  || (!empty($author) && $author==$_SESSION['id']) )
            {
                DBAccess::command("DELETE FROM recensioni WHERE id=".$_GET['rmrev']);
                $msg="OK";
            }else{$error = "Non hai il permesso per compiere questa operazione";}
        }catch(Exception $e){
            $msg="NO";
            $error=$e->getMessage();
        }
    } 
    //inserimento recensione
    else if (isset($_SESSION['id']) && !empty($_POST['review']) && !empty($_POST['rating'])){
        //sanitizzazione review + rating
        $newreview=filter_var($_POST['review'], FILTER_SANITIZE_STRING);
        $rating=filter_var($_POST['rating'], FILTER_SANITIZE_STRING);
        //prelievo id utente per query di inserimento
        try{
            $userid=DBAccess::query("SELECT id FROM utenti WHERE username=\"{$_SESSION['id']}\"")[0]["id"];
            //inserimento in database
            $msg="NO";
            if(!empty($userid) && !empty($newreview) && !empty($rating) && is_numeric($rating) && $rating>=0 && $rating<=10){
                //inserimento recensione
                DBAccess::command("INSERT INTO recensioni (id, utente, birra, descrizione, voto) VALUES (NULL, {$userid},  {$idbirra}, \"{$newreview}\", {$rating})");
                $msg="OK";
            }else{$error = "Non hai il permesso per compiere questa operazione";}
        }catch(Exception $e){
            $msg="NO";
            $error=$e->getMessage();
        }
    }   

    //preleva recensioni della birra
    try{
        $query = 'SELECT recensioni.id AS revid, recensioni.descrizione, recensioni.voto, utenti.username FROM recensioni, utenti WHERE recensioni.birra='.$idbirra.' AND recensioni.utente=utenti.id';
        $recensioni = DBAccess::query($query);
    }catch(Exception $e){
        header('Location: notfound.php');
    }

    //breadcrumbs
    $path=[
        "Home" => "<root/>php/home.php",
        "Prodotti" => "<root/>php/prodotti.php",
        $birra["nome"] => "active",
    ];
    //Costruisco pagina
    $paginaHTML = file_get_contents('../html/dettagli.html');
    $paginaHTML = str_replace("<head/>", htmlMaker::makeHead($birra["nome"]." - La tana del Luppolo"), $paginaHTML);
    $paginaHTML = str_replace("<heading/>", htmlMaker::makeHeading($birra["nome"]), $paginaHTML); 
    $paginaHTML = str_replace("<keywords/>", ", ".$birra["nome"], $paginaHTML); 
    $paginaHTML = str_replace("<bc/>", htmlMaker::makeBreadCrumbs($path), $paginaHTML);
    $paginaHTML = str_replace("<header/>", htmlMaker::makeHeader($username), $paginaHTML);
    $paginaHTML = str_replace("<tornasu/>", htmlMaker::makeTornaSu(), $paginaHTML);
    $paginaHTML = str_replace("<footer/>", htmlMaker::makeFooter(), $paginaHTML);
    $paginaHTML = str_replace("<beerinfo/>", htmlMaker::beerInfo($birra), $paginaHTML);

    //se presente stampa messaggio di risultato query inserimento/eliminazione recensione
    if($msg!="")
    {
        if($msg=="OK")
            $paginaHTML = str_replace("<msg/>", '<div id="msgsuccess">Operazione eseguita con successo!</div>', $paginaHTML);
        else
            $paginaHTML = str_replace("<msg/>", '<div id="msgfail">Operazione fallita. '.$error.'</div>', $paginaHTML);
    }
    else
        $paginaHTML = str_replace("<msg/>", "", $paginaHTML);

    //stampa recensioni
    if(strpos($paginaHTML, "<reviews/>")!==false)
    {
        if($recensioni==null)
            $paginaHTML = str_replace("<reviews/>", '<p>Nessuno ha ancora recensito questa birra.</p>', $paginaHTML);
        else
            $paginaHTML = str_replace("<reviews/>", htmlMaker::beerReview($recensioni), $paginaHTML);
    }

    if(strpos($paginaHTML, "<beerid/>")!==false)
                $paginaHTML = str_replace("<beerid/>", $idbirra, $paginaHTML);

    

    $paginaHTML = str_replace("<root/>", "../", $paginaHTML);
    echo $paginaHTML;


?>