function getSearchbar(){
    var search_box = document.getElementById("searchbar");
    if(search_box.hidden){
        search_box.hidden = false;
        document.getElementById("search").focus();
    }
    else{
        search_box.hidden=true;
    }
     
};