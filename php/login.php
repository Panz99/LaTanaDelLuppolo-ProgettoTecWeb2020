<?php
    require_once 'htmlMaker.php';
    require_once "dbConnection.php";
    session_start();
    $paginaHTML = file_get_contents('../html/login.html');
    //controllo se minorenne
    if(!isset($_SESSION['adult']) || !$_SESSION['adult']){
        header('Location: ageverification.php');
    }
    //controllo se giá loggato
    if(isset($_SESSION['logged']) && $_SESSION['logged']){
        header('Location: dettagliaccount.php');
    }

    //Controllo se sta provando il login
    $error="";
    if (isset($_POST['txtUsername']) && isset($_POST['txtPassword'])) {
        $username=filter_var($_POST['txtUsername'], FILTER_SANITIZE_STRING);
        $password=filter_var($_POST['txtPassword'], FILTER_SANITIZE_STRING);
        try{
            $result= DBAccess::query("SELECT * FROM utenti WHERE username = '$username' AND password='$password'")[0];
            if($result){
                $_SESSION['id']=$username;
                $_SESSION['logged']=true;
                $_SESSION['admin'] = $result['admin_flag'] ?? NULL;
                header('Location: dettagliaccount.php');
            }else{
                $error = "Le credenziali inserite non sono corrette";
            }
        }catch(Exception $e){
            header('Location: accessdenied.php');
        }
    }
    //Genero la pagina
    $path=[
        "Home" => "<root/>php/home.php",
        "Accedi" => "active",
    ];
    
    $paginaHTML = str_replace("<head/>", htmlMaker::makeHead("Accedi - La tana del Luppolo"), $paginaHTML);
    $paginaHTML = str_replace("<keywords/>", ", account", $paginaHTML); 
    $paginaHTML = str_replace("<header/>", htmlMaker::makeHeader(""), $paginaHTML);
    $paginaHTML = str_replace("<heading/>", htmlMaker::makeHeading("Accedi o Registrati"),$paginaHTML);
    $paginaHTML = str_replace("<bc/>", htmlMaker::makeBreadCrumbs($path), $paginaHTML);
    $paginaHTML = str_replace("<tornasu/>", htmlMaker::makeTornaSu(), $paginaHTML);
    $paginaHTML=str_replace("<p class='msgError'></p>","<p class='msgError'>$error</p>",$paginaHTML);
    $paginaHTML = str_replace("<footer/>", htmlMaker::makeFooter(), $paginaHTML);
    $paginaHTML = str_replace("<root/>", "../", $paginaHTML);
    echo $paginaHTML;
?>