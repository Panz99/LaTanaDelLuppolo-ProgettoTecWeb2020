<?php
    require_once 'htmlMaker.php';
    require_once 'dbConnection.php';
    require_once 'validator.php';
    session_start();
    //controllo se minorenne
    if(!isset($_SESSION['adult']) || !$_SESSION['adult']){
      header('Location: ageverification.php');
    }


    $paginaHTML = file_get_contents('../html/dettagliaccount.html');

  
    
   
   $error="";

   $username="";
    //controllo se loggato
    if(isset($_SESSION['login'])){
        $username=$_SESSION['id'];
        //se si fa elimina account
        if(isset($_POST['txtPassword'])){
            $password=$_POST['txtPassword'];

            $PassValid=Validate::validatePass($username,$password);
            if($PassValid==true){
                
                $result=DBAccess::query("DELETE  FROM utenti WHERE username= '$username'");
                unset($_SESSION['id']);
                unset($_SESSION['login']);
                header("Location:login.php");
            }
            else{
                $error="La password inserita non è corretta";
                echo $error;
            }
       }
    
    //Costruisco pagina
    
    $paginaHTML = str_replace("<head/>", htmlMaker::makeHead("Profilo - La tana del Luppolo"), $paginaHTML);
    $paginaHTML = str_replace("<keywords/>", ", account", $paginaHTML); 
    $paginaHTML = str_replace("<header/>", htmlMaker::makeHeader($username), $paginaHTML);
    $paginaHTML = str_replace("<footer/>", htmlMaker::makeFooter(), $paginaHTML);
    $paginaHTML = str_replace("<tornasu/>", htmlMaker::makeTornaSu(), $paginaHTML);
    $paginaHTML = str_replace("<root/>", "../", $paginaHTML);
    $paginaHTML = str_replace("£userid£",$_SESSION['id'],$paginaHTML);
    $paginaHTML = str_replace("£name£",$_SESSION['nome'],$paginaHTML);
    $paginaHTML = str_replace("£surname£",$_SESSION['cogn'],$paginaHTML);
    $paginaHTML = str_replace("£data£",$_SESSION['bdate'],$paginaHTML);
    echo $paginaHTML;
    }
?>