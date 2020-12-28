<?php
    require_once 'htmlMaker.php';
    session_start();
    $paginaHTML = file_get_contents('../html/AgeVerification.html');
    function validateDate($year, $month, $day){
        $error="";
        if($year<1900 || $year>date('Y'))
            $error.="<li>L'anno deve essere un intero compreso tra 1900 e ".date('Y')."</li>";
        if($month<1 || $month>12)
            $error.="<li>Il mese deve essere un intero compreso tra 1 e 12</li>";
        if($day<1 || $day >31)
            $error.="<li>Il giorno deve essere un intero tra 1 e 31</li>";
        if(!checkdate($month, $day, $year))
            $error.="<li>La data non è valida</li>";
        return $error;
    };
    
    $Errore = "";
    if(isset($_POST['year']) && isset($_POST['month']) && isset($_POST['day'])){
        $YearI = $_POST['year'];
        $MonthI = $_POST['month'];
        $DayI = $_POST['day'];
        $YearToday = date('Y');
        $MonthToday = date('m');
        $DayToday = date('d');
        $Errore=validateDate((int)$YearI, (int)$MonthI, (int)$DayI);
        if(!$Errore){
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
            $paginaHTML = str_replace('id="day"', 'id="day" value="'.$DayI.'"', $paginaHTML);
            $paginaHTML = str_replace('id="month"', 'id="month" value="'.$MonthI.'"', $paginaHTML);
            $paginaHTML = str_replace('id="year"', 'id="year" value="'.$YearI.'"', $paginaHTML);
            $Errore="<p class='msgError'>Devi essere maggiorenne per accedere al sito</p>";
        }else{
            $Errore = "<ul class='msgError'>".$Errore."</ul>";
        }
        
    }
    
    if(isset($_SESSION['adult']) && $_SESSION['adult'])
        header('Location: home.php');
    //COSTRUZIONE PAGINA    
    
    $paginaHTML = str_replace("<head/>", htmlMaker::makeHead("Locker - La tana del Luppolo"), $paginaHTML);
    $paginaHTML = str_replace("<keywords/>", "", $paginaHTML); 
    $paginaHTML = str_replace("<nav>", "<nav hidden='hidden'>",
                str_replace('<div id="container_icons">', '<div id="container_icons" class="hidden">',
                str_replace("<header/>", htmlMaker::makeHeader(""),$paginaHTML)));
    $paginaHTML = ($Errore) ? str_replace("<error/>", $Errore, $paginaHTML) : str_replace("<error/>", "", $paginaHTML);
    $paginaHTML = str_replace("<footer/>", htmlMaker::makeFooter(), $paginaHTML);
    $paginaHTML = str_replace("<root/>", "../", $paginaHTML);
    echo $paginaHTML;
?>