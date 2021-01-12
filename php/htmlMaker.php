<?php
class htmlMaker{

    /* Elementi html pagine */

    public static function makeHead($title = "La tana del Luppolo"){
        $html = file_get_contents('../html/components/head.html');
        $html = str_replace("<title/>", "<title>".$title."</title>", $html);
        return $html;

    }
    public static function makeHeader($username){ 
        $html = file_get_contents('../html/components/header.html');
        if($username!=NULL)
            $html = str_replace("<welcome/>", "<span id='msgWelcome'>$username</span>", $html);
        else    
            $html = str_replace("<welcome/>", "<span id='msgWelcome'>Accedi</span>", $html);
        return $html;
        
    }
    public static function makeHeading($title){
        return '<div id="heading"><h1>'.$title.'</h1></div>';
    }
    public static function makeFooter(){
        return file_get_contents('../html/components/footer.html');
    }
    public static function makeTornaSu(){
        return  '<div class="containerTornaSu">
                    <a class="link tornaSu" href="#">Torna su</a>
                </div>';
    }
    public static function makeBreadCrumbs($path){ 
        $html='<ul id="breadcrumbs">';
        foreach($path as $nome => $link){
            $html.= '<li class="bc-item">';
            if($link == "active")
                $html.='<a href="#" class="active">'.$nome.'</a>';
            else    
                $html.='<a href="'.$link.'" class="link">'.$nome.'</a>';
            $html.='</li>';
        }
        $html.='</ul>';
        return $html;
    }



    /* Costruzione pagine */

    public static function listBeers($beers){
        $html = "<p>Non siamo riusciti a trovare ciò che stai cercando<p>";
        if($beers){
            $html = '';
            foreach($beers as $birra){
                $html .= '<div class="prodotto">';
                $html .= '<a class="link nome_prodotto" href="dettagli.php?id='.$birra['id'].'"><h2>' . $birra['nome'] .'</h2></a>'; 
                $html .= '<img class="img_prodotto" alt="Foto bottiglia di birra '.$birra['nome'].'" src="<root/>'.$birra['img_path'].'"/>';
                $html .= '<dl class="dettagli_prodotto">'; 
                $html .= '<dt>Costo:</dt><dd> ' . $birra['costo'] . '€' . '</dd>';   
                $html .= '<dt>Grado:</dt><dd> ' . $birra['grado'] . '°</dd></dl>';
                $html .= '<p class="tipo_prodotto">Stile: ' . str_replace('_', ' ',  $birra['tipo']) . ' </p></div>';
            }
        }
        return $html;
    }

    public static function beerInfo($beer){

        $html = "<p>Non siamo riusciti a trovare ciò che stai cercando</p>"; 

        if($beer){
            $html ='<div id="detailscontainer">
                        <div id="divimgbirra">
                            <img src="<root/>'. $beer["img_path"] . '" id="imgdettagli" alt="Foto birra '. $beer["nome"] . '"/>
                        </div>

                        <div id="divdettagli">                            
                            <dl>
                                <dt><span class="bspan">Tipo</span></dt>
                                <dd>'. str_replace('_', ' ',  $beer['tipo']) . '</dd>
                                    
                                <dt><span class="bspan">Gradi</span></dt>
                                <dd>'. $beer["grado"] . '°</dd>

                                <dt><span class="bspan">Costo</span></dt>
                                <dd>'. $beer["costo"] . '€</dd>
                            </dl>
                            <p>'. $beer["descrizione"] . '</p>
                        </div>
                    </div>
                    <h2 id="recensioneheading">Recensioni</h2>';      
            //se l'utente è loggato aggiungi textbox per inserimento recensione
            $html.= isset($_SESSION['id']) ? 
                '
                        <form action="dettagli.php?id=<beerid/>" method="post" id="revinsertform">   
                            <fieldset>
                                <legend>Inserisci una nuova recensione</legend>
                                <p class="newline"><label for="recensionetextarea">Scrivi cosa pensi della birra</label></p>
                                <textarea id="recensionetextarea" name="review" cols="50" rows="3" placeholder="Scrivi una recensione sulla birra" required="required"></textarea>
                            </fieldset>  
                            <fieldset>
                            <legend>Inserisci una voto</legend>
                                <input type="radio" id="rateradio0" name="rating" value="0" checked="checked"/><label for="rateradio0">0</label>&nbsp;
                                <input type="radio" id="rateradio1" name="rating" value="1"/><label for="rateradio1">1</label>&nbsp;
                                <input type="radio" id="rateradio2" name="rating" value="2"/><label for="rateradio2">2</label>&nbsp;
                                <input type="radio" id="rateradio3" name="rating" value="3"/><label for="rateradio3">3</label>&nbsp;
                                <input type="radio" id="rateradio4" name="rating" value="4"/><label for="rateradio4">4</label>&nbsp;
                                <input type="radio" id="rateradio5" name="rating" value="5"/><label for="rateradio5">5</label>&nbsp;
                                <input type="radio" id="rateradio6" name="rating" value="6"/><label for="rateradio6">6</label>&nbsp;
                                <input type="radio" id="rateradio7" name="rating" value="7"/><label for="rateradio7">7</label>&nbsp;
                                <input type="radio" id="rateradio8" name="rating" value="8"/><label for="rateradio8">8</label>&nbsp;
                                <input type="radio" id="rateradio9" name="rating" value="9"/><label for="rateradio9">9</label>&nbsp;
                                <input type="radio" id="rateradio10" name="rating" value="10"/><label for="rateradio10">10</label>
                            </fieldset>
                            <input class="btn" type="submit" value="Invia recensione"/>
                        </form>
                    ': '';
            $html.='<reviews/>';
        }

        return $html;
    }

    public static function beerReview($reviews){
        $html ="<ul id='recensionelist'>";
        foreach($reviews as $review)
        {
            $html .= '
                    <li class="recensioneitem">
                        <span class="material-icons darknohover" role="presentation" tabindex="-1">account_circle</span>
                        <div class="recensionetext">
                            <p class="newline"><span class="recensioneusername">'.$review["username"].'</span> ha commentato</p>
                            <div class="recensionecontent">'.$review["descrizione"].'</div>
                            <span>Voto: <span class="emspan">'.$review["voto"].'/10</span></span>
                        </div>';
            // Controlla se utente è loggato e aggiunge tasto eliminazione se è l'autore della recensione oppure admin
            $html.= isset($_SESSION['id']) && (isset($_SESSION['admin']) && $_SESSION['admin']==1 || $_SESSION['id']==$review["username"]) ? 
                    '<a href="dettagli.php?id=<beerid/>&rmrev='.$review['revid'].'"><span class="material-icons dark">delete_forever</span></a>'
                    : '';       
            $html.='</li>';
        }
        $html.="</ul>";
        return $html;
    }

    public static function listPages($nBeers, $page){
        $html="";
        if($nBeers!=0){
            $n_pagine = ($nBeers%8==0) ? $nBeers/8 : intdiv($nBeers, 8) + 1;
            //Creo la parte di pagina HTML con elenco delle birre
            $html = '<ul id="list_pages">';
            if($page>2)
                $html .= '<li><a href="prodotti.php?page='.($page-1).'" class="link page-padding fillParent">Precedente</a></li>';
            for($i=1; $i<=$n_pagine; $i++){
                $html .= '<li><a href="prodotti.php?page='.$i.'" class="link page-padding fillParent">'.$i.'</a></li>';
            }
            if($page<$n_pagine-1)
                $html .= '<li><a href="prodotti.php?page='.($page+1).'" class="link page-padding fillParent">Successiva</a></li>';
            $html.='</ul>';
        }
        return $html;
    }


    /* Pagine avvisi ed errori */

    public static function makeNotfound(){

        $back = $_SERVER['HTTP_REFERER'] ?? "javascript:history.go(-1)";
        
        $html = "
        <div id=\"diverror\">
            <h2>Contenuto non trovato. </h2>
            <a class ='link' href=\"{$back}\">Torna indietro</a>
        </div>";

        return $html;
    }
    public static function makeDeleteAccount(){        
        $html = "
        <div id='diverror'>
            <h2>Account eliminato con successo!</h2>
            <a class ='link' href='<root/>php/home.php'>Torna alla home</a>
        </div>";
        return $html;
    }

    public static function makeAccessdenied(){
        $back = $_SERVER['HTTP_REFERER'] ?? "javascript:history.go(-1)";
        
        $html = '
        <div id="diverror">
            <h2>Non hai il permesso di visualizzare questo contenuto. </h2>
            <a class ="link" href="'. $back .'">Torna indietro</a>
        </div>';

        return $html;
    }

    public static function userInfo($utente){
        $html = "<dl id='dettagli'>";
        $html.= "<dt xml:lang='en' lang='en'>Username</dt><dd>".$utente['username']."</dd>";
        if($utente['nome']!=NULL){
            $html.= "<dt>Nome</dt><dd>".$utente['nome']."</dd>";
        }else{
            $html.= "<dt>Nome</dt><dd>Non assegnato</dd>";
        }
        if($utente['cognome']!=NULL){  
            $html.= "<dt>Cognome</dt><dd>".$utente['cognome']."</dd>";
        }else{
            $html.= "<dt>Cognome</dt><dd>Non assegnato</dd>";
        }
        if($utente['email']!=NULL){
            $html.= "<dt xml:lang='en' lang='en'>Email</dt><dd>".$utente['email']."</dd>";
        }else{
            $html.= "<dt xml:lang='en' lang='en'>E-mail</dt><dd>Non assegnato</dd>";      
        }
        $html.= "</dl>";
        return $html;
    }
}

?>