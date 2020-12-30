<?php
    require_once 'htmlMaker.php';
    require_once 'dbConnection.php';
    require_once 'validator.php';
    session_start();
    //controllo se minorenne
    if(!isset($_SESSION['adult']) || !$_SESSION['adult']){
      header('Location: ageverification.php');
    }

   
   $error="";
   $username="";

    //se utente non è loggato redirect a pagina di errore
    if(!isset($_SESSION['login'])){
        header("Location: accessdenied.php");
    }
    
    $username=$_SESSION['id'];
    //se si fa elimina account
    if(isset($_POST['txtPassword'])){
        $password=$_POST['txtPassword'];

        $PassValid=Validate::validatePass($username,$password);
        if($PassValid==true){
            
            DBAccess::command("DELETE  FROM utenti WHERE username= '$username'");
            unset($_SESSION['id']);
            unset($_SESSION['login']);
            header("Location: login.php");
        }
        else{
            $error="La password inserita non è corretta";
        }
    }
    
    //Prelievo informazioni utente
    try{
        $query = 'SELECT nome, cognome, email FROM utenti WHERE username = "'.$username.'"';
        $utente = DBAccess::query($query)[0];
    } catch (Exception $e) {
        //Redirect a pagina errore
        header("Location: notfound.php");
    }
    
    //Breadcrumbs
    $path=[
        "Home" => "<root/>php/home.php",
        "Account" => "active",
    ];

    //Costruisco pagina
    $paginaHTML = file_get_contents('../html/dettagliaccount.html');
    $paginaHTML = ($error) ? str_replace("<error/>", $error, $paginaHTML) : str_replace("<error/>", "", $paginaHTML);
    $paginaHTML = str_replace("<head/>", htmlMaker::makeHead("Profilo - La tana del Luppolo"), $paginaHTML);
    $paginaHTML = str_replace("<keywords/>", ", account", $paginaHTML); 
    $paginaHTML = str_replace("<bc/>", htmlMaker::makeBreadCrumbs($path), $paginaHTML);
    $paginaHTML = str_replace("<header/>", htmlMaker::makeHeader($username), $paginaHTML);
    $paginaHTML = str_replace("<footer/>", htmlMaker::makeFooter(), $paginaHTML);
    $paginaHTML = str_replace("<tornasu/>", htmlMaker::makeTornaSu(), $paginaHTML);
    $paginaHTML = str_replace("<userid/>",$_SESSION['id'],$paginaHTML);
    $paginaHTML = str_replace("<name/>",$utente["nome"] ?? '<span class="ispan">Non assegnato</span>', $paginaHTML);
    $paginaHTML = str_replace("<surname/>",$utente["cognome"] ?? '<span class="ispan">Non assegnato</span>', $paginaHTML);
    $paginaHTML = str_replace("<email/>",$utente['email'] ?? '<span class="ispan">Non assegnato</span>', $paginaHTML);
    $paginaHTML = str_replace("<root/>", "../", $paginaHTML);
    echo $paginaHTML;
    
?>