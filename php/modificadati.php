<?php
    require_once 'htmlMaker.php';
    require_once 'dbConnection.php';
    require_once 'validator.php';
    session_start();
    //controllo se minorenne
    if(!isset($_SESSION['adult']) || !$_SESSION['adult'])
        header('Location: ageverification.php');
    
    
    $paginaHTML = file_get_contents('../html/modificadati.html');
    $paginaHTML = str_replace("<head/>", htmlMaker::makeHead("Modifica Dati - La tana del Luppolo"), $paginaHTML);
    $paginaHTML = str_replace("<keywords/>", ", account, modifica dati", $paginaHTML); 
    $paginaHTML = str_replace("<header/>", htmlMaker::makeHeader(), $paginaHTML);
    $paginaHTML = str_replace("<tornasu/>", htmlMaker::makeTornaSu(), $paginaHTML);
    $paginaHTML = str_replace("<footer/>", htmlMaker::makeFooter(), $paginaHTML);

    $Errore="";
    //controllo se loggato
    if(isset($_SESSION['login'])){
        $username=$_SESSION['id'];
        if(isset($_POST['new-username']) || isset($_POST['new-name']) || isset($_POST['new-surname']) || isset($_POST['new-date']) || isset($_POST['new-password'])){

            if(isset($_POST['txtPassword'])){

                $password = $_POST['txtPassword'];

                $PassCorrect = Validate::validatePass($username,$password);
                try{    
                if($PassCorrect==true){
                    
                    if($new_id=$_POST['new-username']){
                        DBAccess::escape_input(array($username,$new_id));
                        DBAccess::command("UPDATE  utenti SET username = '$new_id' WHERE username = '$username'");
                        $_SESSION['id']=$new_id;
                        
                    }
                    if($nome=$_POST['new-name']){
                        DBAccess::escape_input(array($username,$nome));
                        DBAccess::command("UPDATE  utenti SET nome = '$nome' WHERE username = '$username'");
                        $_SESSION['nome']=$nome;
                    }
                    if($cognome=$_POST['new-surname']){
                        DBAccess::escape_input(array($username,$cognome));
                        DBAccess::command("UPDATE  utenti SET cognome = '$cognome' WHERE username = '$username'");
                        $_SESSION['cogn']=$cognome;
                    }
                    if($mail=$_POST['new-email']){
                        DBAccess::escape_input(array($username,$mail));
                        DBAccess::command("UPDATE  utenti SET email = '$mail' WHERE username = '$username'");
                        $_SESSION['email']=$mail;
                    }
                    if($pass=$_POST['new-password']){
                        DBAccess::escape_input(array($username,$pass));
                        DBAccess::command("UPDATE  utenti SET password = '$pass' WHERE username = '$username'");
                    }
                    
                    header("Location:dettagliaccount.php");
                

                }else{
                $Errore="Password non corretta!";
                }
                }
                catch(Exception $e){
                    $Errore=$e;
                }   

            }
        }
    }

        //Costruisco la pagina normalmente
     

    $paginaHTML = ($Errore) ? str_replace("<error/>", $Errore, $paginaHTML) : str_replace("<error/>", "", $paginaHTML);
    $paginaHTML = str_replace("<root/>", "../", $paginaHTML);
    echo $paginaHTML;
?>