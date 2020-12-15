<?php
    require_once 'htmlMaker.php';
    session_start();
    if(isset($_POST['year']) && $_POST['year'] == 2010)
        $_SESSION['adult'] = true;
    if(isset($_SESSION['adult']) && $_SESSION['adult'])
        header('Location: home.php');
        
    //COSTRUZIONE PAGINA    
    $paginaHTML = file_get_contents('../html/AgeVerification.html');
    $paginaHTML = str_replace("<head/>", htmlMaker::makeHead("Locker - La tana del Luppolo"), $paginaHTML);
    $paginaHTML = str_replace("<root/>", "../", $paginaHTML);
    echo $paginaHTML;
?>