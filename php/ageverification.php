<?php
    session_start();
    if(isset($_POST['year']) && $_POST['year'] == 2010)
        $_SESSION['adult'] = true;
    if(isset($_SESSION['adult']) && $_SESSION['adult'])
        header('Location: home.php');
        
    //COSTRUZIONE PAGINA    
    echo file_get_contents('../html/AgeVerification.html');
?>