<?php
    require_once 'htmlMaker.php';
    require_once 'dbConnection.php';

    session_start();
    //controllo se minorenne
    if(!isset($_SESSION['adult']) || !$_SESSION['adult']){
        header('Location: ageverification.php');
    }
    
    $paginaHTML = file_get_contents('../html/modificadati.html');
    
    if(isset($_SESSION['logged']) && $_SESSION['logged']){
       
        $username = $_SESSION['id'];
        $Errore="";

        if(isset($_POST['new-username']) || isset($_POST['new-name']) || isset($_POST['new-surname']) || isset($_POST['new-date']) || isset($_POST['new-password'])){

            if(isset($_POST['txtConfirmPassword'])){

                $password = $_POST['txtConfirmPassword'];
                try{
                
                    $PassCorrect = DBAccess::query("SELECT password FROM utenti WHERE username = '$username' ",true)[0];
                   
                if($PassCorrect == $password){
                    
                    if($new_id=$_POST['new-username']){
                        $new_id=filter_var($_POST['new-username'], FILTER_SANITIZE_STRING);
                        $Errore .= (!preg_match("/^[\w_]{4,30}$/i", $new_id)) ? "<li>Username non valido, sono ammessi solamente caratteri alfanumerici e il trattino basso e la lunghezza minima è di 4 caratteri</li>" : "";
                        if($Errore==""){
                            DBAccess::escape_input(array($username,$new_id));
                            DBAccess::command("UPDATE  utenti SET username = '$new_id' WHERE username = '$username'");
                            $_SESSION['id']=$new_id;
                            $_SESSION['modificato']=true;
                        }
                    }
                    if($nome=$_POST['new-name']){
                        $nome=filter_var($_POST['new-name'], FILTER_SANITIZE_STRING);
                        $Errore .= (!preg_match("/^[A-Z ,.'-]{3,30}$/i", $nome)) ? "<li>Nome non valido, non sono ammessi numeri e la lunghezza minima è di 3 caratteri</li>" : "";
                        if($Errore==""){
                            DBAccess::escape_input(array($username,$nome));
                            DBAccess::command("UPDATE  utenti SET nome = '$nome' WHERE username = '$username'");
                            $_SESSION['modificato']=true;
                        }
                    }
                    if($cognome=$_POST['new-surname']){
                        $cognome=filter_var($_POST['new-surname'], FILTER_SANITIZE_STRING);
                        $Errore .= (!preg_match("/^[A-Z ,.'-]{3,30}$/i", $cognome)) ? "<li>Cognome non valido, non sono ammessi numeri e la lunghezza minima è di 3 caratteri</li>" : "";
                        if($Errore==""){
                            DBAccess::escape_input(array($username,$cognome));
                            DBAccess::command("UPDATE  utenti SET cognome = '$cognome' WHERE username = '$username'");
                            $_SESSION['modificato']=true;
                        }
                    }
                    if($mail=$_POST['new-email']){
                        $mail=filter_var($_POST['new-email'], FILTER_SANITIZE_STRING);
                        $Errore .= (!preg_match("/[\S]{4,32}@[\w]{4,32}((?:\.[\w]+)+)?(\.(it|com|edu|org|net|eu)){1}/", $mail)) ? "<li>Email non valida, formato accettato: email@dominio.suffisso</li>" : "";
                        if($Errore==""){
                            DBAccess::escape_input(array($username,$mail));
                            DBAccess::command("UPDATE  utenti SET email = '$mail' WHERE username = '$username'");
                            $_SESSION['modificato']=true;
                        }
                    }
                    if($pass=$_POST['new-password']){
                        DBAccess::escape_input(array($username,$pass));
                        DBAccess::command("UPDATE  utenti SET password = '$pass' WHERE username = '$username'");  
                        $_SESSION['modificato']=true;
                    }
                    if($Errore=="")
                        header("Location:dettagliaccount.php");

                }else{
                    $Errore="La <span  xml:lang='en'>password</span> inserita non è corretta!";
                }
                }
                catch(Exception $e){
                    $Errore = "<p class='msgError'>".$e->getMessage()."</p>";
                }   

            }
        }
    }
    
    $path=[
        "Home" => "<root/>php/home.php",
        "Account" => "<root/>php/dettagliaccount.php",
        "Modifica Dati" => "active",
    ];

    
    $paginaHTML = str_replace("<head/>", htmlMaker::makeHead("Modifica Dati - La tana del Luppolo"), $paginaHTML);
    $paginaHTML = str_replace("<keywords/>", ", account, modifica dati", $paginaHTML); 
    $paginaHTML = str_replace("<header/>", htmlMaker::makeHeader($username), $paginaHTML);
    $paginaHTML = str_replace("<heading/>", htmlMaker::makeHeading("Aggiornamento profilo"), $paginaHTML);
    $paginaHTML = str_replace("<bc/>", htmlMaker::makeBreadCrumbs($path), $paginaHTML);
    $paginaHTML = str_replace("<tornasu/>", htmlMaker::makeTornaSu(), $paginaHTML);
    $paginaHTML = str_replace("<footer/>", htmlMaker::makeFooter(), $paginaHTML);
    $paginaHTML = ($Errore) ? str_replace("<error/>", "<p class='msgError'>$Errore</p>", $paginaHTML) : str_replace("<error/>", "", $paginaHTML);
    $paginaHTML = str_replace("<root/>", "../", $paginaHTML);
    echo $paginaHTML;
?>