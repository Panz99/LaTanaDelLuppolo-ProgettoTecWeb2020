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

    $paginaHTML = file_get_contents('../html/modificadati.html');

    function validateModificaDati($name, $surname, $username, $email, $password){
        $error="";
        if($name != NULL){
            $error .= (!preg_match("/^[A-Z ,.'-]{3,30}$/i", $name)) ? "<li>Nome non valido, non sono ammessi numeri e la lunghezza minima è di 3 caratteri</li>" : "";
        }
        if($surname != NULL){
            $error .= (!preg_match("/^[A-Z ,.'-]{3,30}$/i", $surname)) ? "<li>Cognome non valido, non sono ammessi numeri e la lunghezza minima è di 3 caratteri</li>" : "";
        }
        if($username != NULL){
            $error .= (!preg_match("/^[\w_]{4,30}$/i", $username)) ? "<li>Username non valido, sono ammessi solamente caratteri alfanumerici e il trattino basso e la lunghezza minima è di 4 caratteri</li>" : "";
        }
        if($email != NULL){
            $error .= (!preg_match("/[\S]{4,32}@[\w]{4,32}((?:\.[\w]+)+)?(\.(it|com|edu|org|net|eu)){1}/", $email)) ? "<li>Email non valida, dominio sconosciuto</li>" : "";
        }
        if($password != NULL){
            $error .= (!preg_match("/^[\w_]{4,30}$/i", $password)) ? "<li>Password non valida, sono ammessi solamente caratteri alfanumerici e il trattino basso e deve essere di lunghezza compresa tra 4 e 30</li>" : "";
        }
        $error = ($error!=NULL) ? '<ul class="msgError">'.$error.'</ul>' : "";
        return $error;
    }

    $Errore="";
    $username = $_SESSION['id'];
    if(isset($_POST['txtConfirmPassword'])){
        $password = filter_var($_POST['txtConfirmPassword'], FILTER_SANITIZE_STRING);
        try{
            $PassCorrect = DBAccess::query("SELECT password FROM utenti WHERE username = '$username' ",true)[0];
            if($PassCorrect == $password){
                $new_id = (isset($_POST['new-username'])) ? filter_var($_POST['new-username'], FILTER_SANITIZE_STRING) : NULL;
                $new_nome = (isset($_POST['new-name'])) ? filter_var($_POST['new-name'], FILTER_SANITIZE_STRING) : NULL;
                $new_cognome = (isset($_POST['new-surname'])) ? filter_var($_POST['new-surname'], FILTER_SANITIZE_STRING) : NULL;
                $new_mail = (isset($_POST['new-email'])) ? filter_var($_POST['new-email'], FILTER_SANITIZE_STRING) : NULL;
                $new_pass = (isset($_POST['new-password'])) ? filter_var($_POST['new-password'], FILTER_SANITIZE_STRING) : NULL;
                $Errore = validateModificaDati($new_nome, $new_cognome, $new_id, $new_mail, $new_pass);
                if(!$Errore){
                    if($new_id){
                        DBAccess::command("UPDATE  utenti SET username = '$new_id' WHERE username = '$username'");
                        $_SESSION['id']=$username=$new_id;
                        $_SESSION['modificato']=true;
                    }
                    if($new_nome){
                        DBAccess::command("UPDATE  utenti SET nome = '$new_nome' WHERE username = '$username'");
                        $_SESSION['modificato']=true;
                    }
                    if($new_cognome){
                        DBAccess::command("UPDATE  utenti SET cognome = '$new_cognome' WHERE username = '$username'");
                        $_SESSION['modificato']=true;
                    }
                    if($new_mail){
                        DBAccess::command("UPDATE  utenti SET email = '$new_mail' WHERE username = '$username'");
                        $_SESSION['modificato']=true;
                    }
                    if($new_pass){
                        DBAccess::command("UPDATE  utenti SET password = '$new_pass' WHERE username = '$username'");  
                        $_SESSION['modificato']=true;
                    }
                    header("Location:dettagliaccount.php");
                }else{
                    $paginaHTML = str_replace('id="txtName"', 'id="txtName" value="'.$new_nome.'"', $paginaHTML);
                    $paginaHTML = str_replace('id="txtSurname"', 'id="txtSurname" value="'.$new_cognome.'"', $paginaHTML);
                    $paginaHTML = str_replace('id="txtUsername"', 'id="txtUsername" value="'.$new_id.'"', $paginaHTML);
                    $paginaHTML = str_replace('id="txtEmail"', 'id="txtEmail" value="'.$new_mail.'"', $paginaHTML);
                    $paginaHTML = str_replace('id="txtPassword"', 'id="txtPassword" value="'.$new_pass.'"', $paginaHTML);
                }
            }else{
                $Errore="<p class='msgError'>La <span  xml:lang='en'>password</span> inserita non è corretta!</>";
            }  
        }catch(Exception $e){
            $Errore = "<p class='msgError'>".$e->getMessage()."</p>";
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
    $paginaHTML = ($Errore) ? str_replace("<error/>", "$Errore", $paginaHTML) : str_replace("<error/>", "", $paginaHTML);
    $paginaHTML = str_replace("<root/>", "../", $paginaHTML);
    echo $paginaHTML;
?>