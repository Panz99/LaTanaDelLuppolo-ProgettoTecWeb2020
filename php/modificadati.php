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
                        $new_id=filter_var($_POST['new-username'], FILTER_SANITIZE_STRING);
                        $Errore .= (!preg_match("/^[\w_]{4,30}$/i", $new_id)) ? "<li>Username non valido, sono ammessi solamente caratteri alfanumerici e il trattino basso e la lunghezza minima è di 4 caratteri</li>" : "";
                        if($Errore==""){
                            DBAccess::escape_input(array($username,$new_id));
                            DBAccess::command("UPDATE  utenti SET username = '$new_id' WHERE username = '$username'");
                            $_SESSION['id']=$new_id;
                        }
                    }
                    if($nome=$_POST['new-name']){
                        $nome=filter_var($_POST['new-name'], FILTER_SANITIZE_STRING);
                        $Errore .= (!preg_match("/^[A-Z ,.'-]{3,30}$/i", $nome)) ? "<li>Nome non valido, non sono ammessi numeri e la lunghezza minima è di 3 caratteri</li>" : "";
                        if($Errore==""){
                            DBAccess::escape_input(array($username,$nome));
                            DBAccess::command("UPDATE  utenti SET nome = '$nome' WHERE username = '$username'");
                            $_SESSION['nome']=$nome;
                        }
                    }
                    if($cognome=$_POST['new-surname']){
                        $cognome=filter_var($_POST['new-surname'], FILTER_SANITIZE_STRING);
                        $Errore .= (!preg_match("/^[A-Z ,.'-]{3,30}$/i", $cognome)) ? "<li>Cognome non valido, non sono ammessi numeri e la lunghezza minima è di 3 caratteri</li>" : "";
                        if($Errore==""){
                            DBAccess::escape_input(array($username,$cognome));
                            DBAccess::command("UPDATE  utenti SET cognome = '$cognome' WHERE username = '$username'");
                            $_SESSION['cogn']=$cognome;
                        }
                    }
                    if($mail=$_POST['new-email']){
                        $mail=filter_var($_POST['new-email'], FILTER_SANITIZE_STRING);
                        $Errore .= (!preg_match("/[\S]{4,32}@[\w]{4,32}((?:\.[\w]+)+)?(\.(it|com|edu|org|net|eu)){1}/", $mail)) ? "<li>Email non valida, formato accettato: email@dominio.suffisso</li>" : "";
                        if($Errore==""){
                            DBAccess::escape_input(array($username,$mail));
                            DBAccess::command("UPDATE  utenti SET email = '$mail' WHERE username = '$username'");
                            $_SESSION['email']=$mail;
                        }
                    }
                    if($pass=$_POST['new-password']){
                        DBAccess::escape_input(array($username,$pass));
                        DBAccess::command("UPDATE  utenti SET password = '$pass' WHERE username = '$username'");  
                    }
                    if($Errore=="")
                        header("Location:dettagliaccount.php");
                    else{
                        $paginaHTML = str_replace('id="txtName"', 'id="txtName" value="'.$_POST['new-name'].'"', $paginaHTML);
                        $paginaHTML = str_replace('id="txtSurname"', 'id="txtSurname" value="'.$_POST['new-surname'].'"', $paginaHTML);
                        $paginaHTML = str_replace('id="txtUsername"', 'id="txtUsername" value="'.$_POST['new-username'].'"', $paginaHTML);
                        $paginaHTML = str_replace('id="txtEmail"', 'id="txtEmail" value="'.$_POST['new-email'].'"', $paginaHTML);
                        $paginaHTML = str_replace('id="txtPassword"', 'id="txtPassword" value="'.$_POST['new-password'].'"', $paginaHTML);
                    }
                

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
     
    $paginaHTML = str_replace("<head/>", htmlMaker::makeHead("Modifica Dati - La tana del Luppolo"), $paginaHTML);
    $paginaHTML = str_replace("<keywords/>", ", account, modifica dati", $paginaHTML); 
    $paginaHTML = str_replace("<header/>", htmlMaker::makeHeader($username), $paginaHTML);
    $paginaHTML = str_replace("<tornasu/>", htmlMaker::makeTornaSu(), $paginaHTML);
    $paginaHTML = str_replace("<footer/>", htmlMaker::makeFooter(), $paginaHTML);
    $paginaHTML = ($Errore) ? str_replace("<error/>", $Errore, $paginaHTML) : str_replace("<error/>", "", $paginaHTML);
    $paginaHTML = str_replace("<root/>", "../", $paginaHTML);
    echo $paginaHTML;
?>