<?php
    require_once 'htmlMaker.php';
    session_start();
    if(isset($_POST['year']) && isset($_POST['month']) && isset($_POST['day'])){
        $YearI = $_POST['year'];
        $MonthI = $_POST['month'];
        $DayI = $_POST['day'];
        $YearToday = date('Y');
        $MonthToday = date('m');
        $DayToday = date('d');
        if(($YearToday-$YearI) > 18){
            $_SESSION['adult']=true;
        }else if(($YearToday-$YearI) == 18){
            if($MonthI < $MonthToday){
                $_SESSION['adult']=true;
            }else if($MonthI == $MonthToday){
                if($DayI <= $DayToday){
                    $_SESSION['adult']=true;
                }
            }
        }
    }

    if(isset($_SESSION['adult']) && $_SESSION['adult'])
        header('Location: home.php');
        
    //COSTRUZIONE PAGINA    
    $paginaHTML = file_get_contents('../html/AgeVerification.html');
    $paginaHTML = str_replace("<head/>", htmlMaker::makeHead("Locker - La tana del Luppolo"), $paginaHTML);
    $paginaHTML = str_replace("<keywords/>", "", $paginaHTML); 
    $paginaHTML =str_replace("<nav>", "<nav hidden>",
                str_replace('<div id="container_icons">', '<div id="container_icons" hidden>',
                str_replace("<header/>", htmlMaker::makeHeader(),$paginaHTML)));
    $paginaHTML = str_replace("<footer/>", htmlMaker::makeFooter(), $paginaHTML);
    $paginaHTML = str_replace("<root/>", "../", $paginaHTML);
    echo $paginaHTML;
?>