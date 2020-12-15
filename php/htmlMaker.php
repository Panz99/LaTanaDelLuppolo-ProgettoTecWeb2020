<?php
class htmlMaker{

    public static function listBeers($beers){
        $html = "<p>Non siamo riusciti a trovare ciò che stai cercando<p>";
        if($beers){
            $html = '<div id="container_beers">';
            foreach($beers as $birra){
                $html .= '<a class="link_prodotto" href="dettagli.php?id='.$birra['id'].'">';
                $html .= '<div class="prodotto">';
                $html .= '<h2 class="nome_prodotto">' . $birra['nome'] .'</h2>';     
                //$html .= '<div class="contenuto_prodotto">';
                $html .= '<img class="img_prodotto" src="<root/>'.$birra['img_path'].'"/>';
                $html .= '<dl class="dettagli_prodotto">'; 
                $html .= '<dt>Costo:</dt><dd> ' . $birra['costo'] . '€' . '</dd>';   
                $html .= '<dt>Grado:</dt><dd> ' . $birra['grado'] . '°</dd></dl>';
                $html .= '<p class="tipo_prodotto">Stile: ' . str_replace('_', ' ',  $birra['tipo']) . ' </p></div>';
                //$html .= '</div>';
            }
            $html .= '</a></div>';
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
                $html .= '<li class="page"><a href="prodotti.php?page='.($page-1).'" class="link page-padding">Precedente</a></li>';
            for($i=1; $i<=$n_pagine; $i++){
                $html .= '<li class="page"><a href="prodotti.php?page='.$i.'" class="link page-padding">'.$i.'</a></li>';
            }
            if($page<$n_pagine)
                $html .= '<li class="page"><a href="prodotti.php?page='.($page+1).'" class="link page-padding">Successiva</a></li>';
            $html.='</ul>';
        }
        return $html;
    }
}

?>