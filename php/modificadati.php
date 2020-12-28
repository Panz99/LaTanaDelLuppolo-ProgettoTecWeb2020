<?php
    require_once 'htmlMaker.php';
    require_once 'dbConnection.php';
    require_once 'validator.php';
    session_start();
    //controllo se minorenne
    if(!isset($_SESSION['adult']) || !$_SESSION['adult'])
        header('Location: ageverification.php');
    
        $username = "";
    if(isset($_SESSION['id'])){
        $username = $_SESSION['id'];
    }
    
    $paginaHTML = file_get_contents('../html/modificadati.html');
    $paginaHTML = str_replace("<head/>", htmlMaker::makeHead("Modifica Dati - La tana del Luppolo"), $paginaHTML);
    $paginaHTML = str_replace("<keywords/>", ", account, modifica dati", $paginaHTML); 
    $paginaHTML = str_replace("<header/>", htmlMaker::makeHeader($username), $paginaHTML);
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

                if($PassCorrect==true){
               
                    if(isset($_POST['new-username'])){
                        $new_id=$_POST['new-username'];
                        DBAccess::escape_input(array($username,$new_id));
                        $result=DBAccess::query("UPDATE  utenti SET username = '$new_id' WHERE username = '$username'");
                    }
                    if($nome=$_POST['new-name']){
                        DBAccess::escape_input(array($username,$nome));
                        $result=DBAccess::query("UPDATE  utenti SET nome = '$nome' WHERE username = '$username'");
                    }
                    if($cognome=$_POST['new-surname']){
                        DBAccess::escape_input(array($username,$cognome));
                        $result=DBAccess::query("UPDATE  utenti SET cognome = '$cognome' WHERE username = '$username'");
                    }
                    if($data=$_POST['new-date']){
                        DBAccess::escape_input(array($username,$data));
                        $result=DBAccess::query("UPDATE  utenti SET data_nascita = '$data' WHERE username = '$username'");
                    }
                    if($pass=$_POST['new-password']){
                        DBAccess::escape_input(array($username,$pass));
                        $result=DBAccess::query("UPDATE  utenti SET password = '$pass' WHERE username = '$username'");
                    }

                }else{
                $Errore="Password non corretta!";
                }
            }
        }
    }

        //Costruisco la pagina normalmente
     

    $paginaHTML = ($Errore) ? str_replace("<error/>", $Errore, $paginaHTML) : str_replace("<error/>", "", $paginaHTML);
    $paginaHTML = str_replace("<root/>", "../", $paginaHTML);
    echo $paginaHTML;
?>