<?php
    require_once 'htmlMaker.php';
    session_start();
    $paginaHTML = file_get_contents('../html/AgeVerification.html');
    function validateDate($year, $month, $day){
        $error="";
        if($year<1900 || $year>date('Y'))
            $error.="<span>L'anno deve essere un intero compreso tra 1900 e ".date('Y')."</span><br/>";
        if($month<1 || $month>12)
            $error.="<span>Il mese deve essere un intero compreso tra 1 e 12</span><br/>";
        if($day<1 || $day >31)
            $error.="<span>Il giorno deve essere un intero tra 1 e 31</span><br/>";
        if(!checkdate($month, $day, $year))
            $error.="<span>La data non è valida</span><br/>";
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
            $Errore="Devi essere maggiorenne per accedere al sito";
        }
        
    }
    
    if(isset($_SESSION['adult']) && $_SESSION['adult'])
        header('Location: home.php');
    //COSTRUZIONE PAGINA    
    
    $paginaHTML = str_replace("<head/>", htmlMaker::makeHead("Locker - La tana del Luppolo"), $paginaHTML);
    $paginaHTML = str_replace("<keywords/>", "", $paginaHTML); 
    $paginaHTML = str_replace("<nav>", "<nav hidden='hidden'>",
                str_replace('<div id="container_icons">', '<div id="container_icons" hidden="hidden">',
                str_replace("<header/>", htmlMaker::makeHeader(),$paginaHTML)));
    if($Errore){$paginaHTML = str_replace("<p class='msgError'>", "<p class='msgError'>".$Errore, $paginaHTML);}
    $paginaHTML = str_replace("<footer/>", htmlMaker::makeFooter(), $paginaHTML);
    $paginaHTML = str_replace("<root/>", "../", $paginaHTML);
    echo $paginaHTML;
?>