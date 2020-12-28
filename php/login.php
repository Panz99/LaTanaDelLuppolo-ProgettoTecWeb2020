<?php
    require_once 'htmlMaker.php';
    require_once "dbConnection.php";
    session_start();
    $paginaHTML = file_get_contents('../html/login.html');
    //controllo se minorenne
    if(!isset($_SESSION['adult']) || !$_SESSION['adult']){
        header('Location: ageverification.php');
    }
    
    //-------------Controllo di login---------------------
    if (isset($_POST['txtUsername']) && isset($_POST['txtPassword'])) {
        // se l'utente ha provato di loggarsi 
            $username =$_POST["txtUsername"];
            $password=$_POST["txtPassword"];
            DBAccess::escape_input(array($username,$password));
            $result= DBAccess::query("SELECT* FROM utenti WHERE username = '$username' AND password='$password'");
            if($result)
            {
                $row = $result[0];
                $_SESSION['id']=$username;
                $_SESSION['login']=true;
                $_SESSION['nome'] = $row['nome'];
                $_SESSION['cogn'] = $row['cognome'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['admin'] = $row['admin_flag'] ?? NULL;
                
            }
        }
        if(isset($_SESSION['id'])){
            header("Location:dettagliaccount.php");
        }
        else{
            if (isset($username)) {
                // se hanno provato ma fallito di loggarsi 
                $_SESSION['id']=$username; 
        
            }
            
            
            
        }
    //------------------------------------------------------------------------------------------------
    //quando si è sbagliato di inserire le credenziali giusti
    if(isset($_SESSION['id']) && !isset($_SESSION['login'])) {
        unset($_SESSION['id']);
        $paginaHTML=str_replace("<p class='msgError'></p>","<p class='msgError'>Le credenziali inserite non sono corrette</p>",$paginaHTML);
    }
<<<<<<< HEAD
    //------------------------------
=======
    //controllo se loggato
    if(isset($_SESSION['login']) && $_SESSION['login']){
        header('Location: dettagliaccount.php');
    }

    $path=[
        "Home" => "<root/>php/home.php",
        "Accedi" => "active",
    ];
    
>>>>>>> 5856421386455b77d6bdb9cae8ee3882a5219726
    $paginaHTML = str_replace("<head/>", htmlMaker::makeHead("Accedi - La tana del Luppolo"), $paginaHTML);
    $paginaHTML = str_replace("<keywords/>", ", account", $paginaHTML); 
    $paginaHTML = str_replace("<header/>", htmlMaker::makeHeader(""), $paginaHTML);
    $paginaHTML = str_replace("<bc/>", htmlMaker::makeBreadCrumbs($path), $paginaHTML);
    $paginaHTML = str_replace("<tornasu/>", htmlMaker::makeTornaSu(), $paginaHTML);
    $paginaHTML = str_replace("<footer/>", htmlMaker::makeFooter(), $paginaHTML);
    $paginaHTML = str_replace("<root/>", "../", $paginaHTML);
    echo $paginaHTML;
?>