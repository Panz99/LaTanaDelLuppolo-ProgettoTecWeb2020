<?php
    require_once 'htmlMaker.php';
    require_once 'dbConnection.php';
    session_start();
    //controllo se minorenne
    if(!isset($_SESSION['adult']) || !$_SESSION['adult']){
      header('Location: ageverification.php');
    }
    //controllo se non é loggato
    if(!isset($_SESSION['logged'])){
        header("Location: accessdenied.php");
    }

    $paginaHTML = file_get_contents('../html/dettagliaccount.html');
    $username=$_SESSION['id'];
    $error="";
    //controllo se ha caricato la pagina per eliminare l'account
    if(isset($_POST['txtPassword'])){
        $password= filter_var($_POST['txtPassword'], FILTER_SANITIZE_STRING);
        $error="";
        try{
            //controllo se la password inserita per l'eliminazione é corretta
            $passwAccount=DBAccess::query("SELECT password FROM utenti WHERE username = '$username' ",true)[0];
            if($password == $passwAccount){
                DBAccess::command("DELETE FROM utenti WHERE username= '$username'");
                $_SESSION['account_deleted']=true;
                unset($_SESSION['id']);
                unset($_SESSION['logged']);
                header("Location: deleteaccount.php");
            }
            else{
                $error="La password inserita non è corretta";
            }
        }catch(Exception $e){
            $error = $e->getMessage();
        }
    }
    //Carico la pagina normalmente
    try{
        $utente = DBAccess::query("SELECT username, nome, cognome, email FROM utenti WHERE username ='$username'")[0];
        $paginaHTML = str_replace("<user/>", htmlMaker::userInfo($utente), $paginaHTML);
    } catch (Exception $e) {
        header("Location: notfound.php");
    }

    //Breadcrumbs
    $path=[
        "Home" => "<root/>php/home.php",
        "Account" => "active",
    ];

    //Costruisco pagina
    $paginaHTML = (isset($_SESSION['modificato']) && $_SESSION['modificato']) ? str_replace("<msg/>", "<div id='msgsuccess'>Operazione eseguita con successo!</div>",$paginaHTML) : str_replace("<msg/>","",$paginaHTML);
    unset($_SESSION['modificato']);
    $paginaHTML = str_replace("<head/>", htmlMaker::makeHead("Profilo - La tana del Luppolo"), $paginaHTML);
    $paginaHTML = str_replace("<keywords/>", ", account", $paginaHTML); 
    $paginaHTML = str_replace("<bc/>", htmlMaker::makeBreadCrumbs($path), $paginaHTML);
    $paginaHTML = str_replace("<header/>", htmlMaker::makeHeader($username), $paginaHTML);
    $paginaHTML = str_replace("<heading/>", htmlMaker::makeHeading("Profilo"), $paginaHTML);
    $paginaHTML = ($error) ? str_replace("<error/>", "<p class='msgError'>$error</p>", $paginaHTML) : str_replace("<error/>", "", $paginaHTML);
    $paginaHTML = str_replace("<footer/>", htmlMaker::makeFooter(), $paginaHTML);
    $paginaHTML = str_replace("<tornasu/>", htmlMaker::makeTornaSu(), $paginaHTML);
    $paginaHTML = str_replace("<root/>", "../", $paginaHTML);
    echo $paginaHTML;
    
?>