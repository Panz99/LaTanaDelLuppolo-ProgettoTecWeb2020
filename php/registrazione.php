<?php
    require_once 'htmlMaker.php';
    require_once 'dbConnection.php';
    session_start();
    $paginaHTML = file_get_contents('../html/registrazione.html');

    function validateRegistrazione($name, $surname, $username, $email, $password){
        $error="";
        if($name!=NULL && $surname!=NULL && $username!=NULL && $email!=NULL && $password!=NULL){
            $error .= (!preg_match("/^[A-Z ,.'-]{3,30}$/i", $name)) ? "<li>Nome non valido, non sono ammessi numeri e la lunghezza minima è di 3 caratteri</li>" : "";
            $error .= (!preg_match("/^[A-Z ,.'-]{3,30}$/i", $surname)) ? "<li>Cognome non valido, non sono ammessi numeri e la lunghezza minima è di 3 caratteri</li>" : "";
            $error .= (!preg_match("/^[\w_]{4,30}$/i", $username)) ? "<li>Username non valido, sono ammessi solamente caratteri alfanumerici e il trattino basso e la lunghezza minima è di 4 caratteri</li>" : "";
            $error .= (!preg_match("/[\S]{4,32}@[\w]{4,32}((?:\.[\w]+)+)?(\.(it|com|edu|org|net|eu)){1}/", $email)) ? "<li>Email non valida, formato accettato: email@dominio.suffisso</li>" : "";
            $error = ($error!=NULL) ? '<ul class="msgError">'.$error.'</ul>' : "";
        }else{
            $error="<p class='msgError'>Tutti i campi devono essere inseriti</p>";
        }
        return $error;
    }
    //controllo se minorenne
    if(!isset($_SESSION['adult']) || !$_SESSION['adult'])
        header('Location: ageverification.php');

    $Errore="";
    //controllo se loggato
    if(isset($_SESSION['id'])){
        //se è loggto non ha la possibilità di registrare un nuovo account, non dovrebbe poter arrivare a questa pagina
        header('Location: accessdenied.php');
    }
    //SONO ARRIVATO QUI PREMENDO IL TASTO REGISTRATI
    if(isset($_POST['registrati'])){
        $name=filter_var($_POST['txtName'], FILTER_SANITIZE_STRING);
        $surname=filter_var($_POST['txtSurname'], FILTER_SANITIZE_STRING);
        $username=filter_var($_POST['txtUsername'], FILTER_SANITIZE_STRING);
        $email=filter_var($_POST['txtEmail'], FILTER_SANITIZE_STRING);
        $password=filter_var($_POST['txtPassword'], FILTER_SANITIZE_STRING);
        $Errore = validateRegistrazione($name, $surname, $username, $email, $password);
        if(!$Errore){
            try{
                DBAccess::command("INSERT INTO utenti (username, password, nome, cognome, email) VALUES ('$username', '$password', '$name', '$surname', '$email')");
                $_SESSION['id']=$username;
                $_SESSION['login']=true;
                header('Location: dettagliaccount.php');
            }catch(Exception $e){
                $Errore = $e;
            }
        }else{
            $paginaHTML = str_replace('id="txtName"', 'id="txtName" value="'.$_POST['txtName'].'"', $paginaHTML);
            $paginaHTML = str_replace('id="txtSurname"', 'id="txtSurname" value="'.$_POST['txtSurname'].'"', $paginaHTML);
            $paginaHTML = str_replace('id="txtUsername"', 'id="txtUsername" value="'.$_POST['txtUsername'].'"', $paginaHTML);
            $paginaHTML = str_replace('id="txtEmail"', 'id="txtEmail" value="'.$_POST['txtEmail'].'"', $paginaHTML);
            $paginaHTML = str_replace('id="txtPassword"', 'id="txtPassword" value="'.$_POST['txtPassword'].'"', $paginaHTML);
        }
    }
    //Costruisco la pagina normalmente se non sono entrato in nessun if
    $path=[
        "Home" => "<root/>php/home.php",
        "Accedi" => "<root/>php/login.php",
        "Registrati" => "active",
    ];

    $paginaHTML = str_replace("<head/>", htmlMaker::makeHead("Registrati - La tana del Luppolo"), $paginaHTML);
    $paginaHTML = str_replace("<keywords/>", ", account, registrazione", $paginaHTML); 
    $paginaHTML = str_replace("<header/>", htmlMaker::makeHeader(""), $paginaHTML);
    $paginaHTML = str_replace("<bc/>", htmlMaker::makeBreadCrumbs($path), $paginaHTML);
    $paginaHTML = str_replace("<tornasu/>", htmlMaker::makeTornaSu(), $paginaHTML);
    $paginaHTML = str_replace("<footer/>", htmlMaker::makeFooter(), $paginaHTML);
    $paginaHTML = ($Errore) ? str_replace("<error/>", $Errore, $paginaHTML) : str_replace("<error/>", "", $paginaHTML);
    $paginaHTML = str_replace("<root/>", "../", $paginaHTML);
    echo $paginaHTML;
?>