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
function validateName(name){
    var re = /^[A-Z ,.'-]{3,30}$/i;
    var span = document.getElementById("nameError");
    if(name=="" || !re.test(name)){ 
        span.innerHTML="Nome non valido, non sono ammessi numeri e la lunghezza minima è di 3 caratteri";
        return false;
    }else{
        span.innerHTML="";
        return true;
    }
}

function validateSurname(surname){
    var re = /^[A-Z ,.'-]{3,30}$/i;
    var span = document.getElementById("surnameError");
    if(surname=="" || !re.test(surname)){ 
        span.innerHTML="Cognome non valido, non sono ammessi numeri e la lunghezza minima è di 3 caratteri";
        return false;
    }else{
        span.innerHTML="";
        return true;
    }
}
function validateUsername(username){
    var re = /^[\w_]{4,30}$/i;
    var span = document.getElementById("usernameError");
    if(username=="" || !re.test(username)){ 
        span.innerHTML="Username non valido, sono ammessi solamente caratteri alfanumerici e il trattino basso e la lunghezza minima è di 4 caratteri";
        return false;
    }else{
        span.innerHTML="";
        return true;
    }
}
function validatePassword(password){
    var span = document.getElementById("passwordError");
    if(password==""){
        span.innerHTML="Password assente";
        return false;
    }else{
        span.innerHTML="";
        return true;
    }
}
function validateEmail(email){
    var re = /[\S]{4,32}@[\w]{4,32}((?:\.[\w]+)+)?(\.(it|com|edu|org|net|eu)){1}/;
    var span = document.getElementById("emailError");
    if(email=="" || !re.test(email)){ 
        span.innerHTML="Email non valida, formato accettato: email@dominio.suffisso";
        return false;
    }else{
        span.innerHTML="";
        return true;
    }
    
}
function checkRegistrazione(){
    var name = document.getElementById("txtName").value.trim();
    var surname = document.getElementById("txtSurname").value.trim();
    var username = document.getElementById("txtUsername").value.trim();
    var email = document.getElementById("txtEmail").value.trim();
    var password = document.getElementById("txtPassword").value.trim();
    if(validateName(name) & validateSurname(surname) & validateUsername(username) & validateEmail(email) & validatePassword(password))
        return true;
    return false;
}

function checkLogin(){
    var username = document.getElementById("txtUsername").value.trim();
    var password = document.getElementById("txtPassword").value.trim();
    if(validateUsername(username) & validatePassword(password))
        return true;
    return false;
}