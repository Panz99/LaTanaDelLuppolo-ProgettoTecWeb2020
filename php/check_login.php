<?php
 require_once "dbConnection.php";
 session_start();
if (isset($_POST['txtUsername']) && isset($_POST['txtPassword'])) {
// se l'utente ha provato di loggarsi 
    $username =$_POST["txtUsername"];
    $password=$_POST["txtPassword"];
    DBAccess::escape_input(array($username,$password));
    $result= DBAccess::query("SELECT* FROM utenti WHERE username = '$username' AND password='$password'");
    if($result)
    {
        $row = $result[0];
        $_SESSION['id']=$username;
        $_SESSION['login']=true;
        $_SESSION['nome'] = $row['nome'];
        $_SESSION['cogn'] = $row['cognome'];
		$_SESSION['bdate'] = $row['data_nascita'];
        
    }
}
if(isset($_SESSION['id'])){
    header("Location:dettagliprofilo.php");
}
else{
    if (isset($username)) {
        // se hanno provato ma fallito di loggarsi 
        $_SESSION['id']=$username; 

    }
    
    header("Location:login.php");
    
}
?>