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
            $html = str_replace("<welcome/>", "<span id='msgWelcome'>Benvenut* $username</span>", $html);
        else    
            $html = str_replace("<welcome/>", "<span id='msgWelcome'>Accedi o registrati cliccando il simbolo dell'omino</span>", $html);
        return $html;
        
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
                $html.='<a href="'.$link.'" class=" link">'.$nome.'</a>';
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
                $html .= '<img class="img_prodotto" alt="bottiglia di birra" src="<root/>'.$birra['img_path'].'"/>';
                $html .= '<dl class="dettagli_prodotto">'; 
                $html .= '<dt>Costo:</dt><dd> ' . $birra['costo'] . '€' . '</dd>';   
                $html .= '<dt>Grado:</dt><dd> ' . $birra['grado'] . '°</dd></dl>';
                $html .= '<p class="tipo_prodotto">Stile: ' . str_replace('_', ' ',  $birra['tipo']) . ' </p></div>';
            }
        }
        return $html;
    }

    public static function beerInfo($beer){

        $html = "<p>Non siamo riusciti a trovare ciò che stai cercando<p>"; 

        if($beer){
            $html ='<div id="detailscontainer">
                        <div id="divimgbirra">
                            <img src="<root/>'. $beer["img_path"] . '" id="imgdettagli" alt="Foto birra '. $beer["nome"] . '">
                        </div>

                        <div id="divdettagli">
                            <div id="descrizionebirra">
                                <h1><strong>'. $beer["nome"] .'</strong></h1>
                                
                                <dl>
                                    <dt><b>Tipo</b></dt>
                                    <dd>'. str_replace('_', ' ',  $beer['tipo']) . '</dd>
                                    
                                    <dt><b>Gradi</b></dt>
                                    <dd>'. $beer["grado"] . '°</dd>

                                    <dt><b>Costo</b></dt>
                                    <dd>'. $beer["costo"] . '€</dd>
                                </dl>

                                <p>'. $beer["descrizione"] . '</p>
                            </div>

                            <div id="recensionisection">
                                <h1>Recensioni</h1>
                                <div id="recensionecreate">
                                    <div class="recensioneuserpic">
                                        <div class="material-icons">account_circle</div>
                                    </div>
                                    <div id="recensionetext">
                                        <span class="recensioneusername">Tu</span><br>
                                        <textarea id="recensionetextarea" cols="50" rows="3" placeholder="Scrivi una recensione sulla birra"></textarea><br>
                                        <input type="submit" value="Invia recensione"> 
                                    </div>
                                </div>
                                <reviews/>
                            </div>
                        </div>
                    </div>';
        }

        return $html;
    }

    public static function beerReview($reviews){
        $html ="";

        foreach($reviews as $review)
        {
            $html .= '
                    <div class="recensioneitem">
                        <div class="recensionetools">
                            <div class="material-icons">account_circle</div>';

            // Aggiunge strumenti di amministrazione se utente è admin
            $html.= isset($_SESSION['admin']) ? '   <br>
                                                    <form action="dettagli.php?id=<beerid/>" method="post" class="revremoveform">
                                                        <button type="submit" id="revremovebut"><div class="material-icons">delete_forever</div></button>
                                                        <input type="hidden" name="removeid" value="'.$review['revid'].'">
                                                    </form>' 
                                            : '';   

            $html.= '</div>
                        <div id="recensionetext">
                            <span class="recensioneusername">'.$review["username"].'</span> ha commentato<br>
                            <div class="recensionecontent">'.$review["descrizione"].'</div>
                            Voto: <em>'.$review["voto"].'/10</em>
                        </div>
                    </div>';
        }

        return $html;
    }

    public static function listPages($nBeers, $page){
        $html="";
        if($nBeers!=0){
            $n_pagine = ($nBeers%8==0) ? $nBeers/8 : intdiv($nBeers, 8) + 1;
            //Creo la parte di pagina HTML con elenco delle birre
            $html = '<ul id="list_pages">';
            if($page>1)
                $html .= '<li><a href="prodotti.php?page='.($page-1).'" class="link page-padding fillParent">Precedente</a></li>';
            for($i=1; $i<=$n_pagine; $i++){
                $html .= '<li><a href="prodotti.php?page='.$i.'" class="link page-padding fillParent">'.$i.'</a></li>';
            }
            if($page<$n_pagine)
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
            <h2>Contenuto non trovato. </h2><br>
            <a href=\"{$back}\">Torna indietro</a>
        </div>";

        return $html;
    }

    public static function makeAccessdenied(){
        $back = $_SERVER['HTTP_REFERER'] ?? "javascript:history.go(-1)";
        
        $html = '
        <div id="diverror">
            <h2>Non hai il permesso di visualizzare questo contenuto. </h2><br>
            <a href="'. $back .'">Torna indietro</a>
        </div>';

        return $html;
    }


}

?>