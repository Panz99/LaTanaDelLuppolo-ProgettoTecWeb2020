<?php
    require_once 'dbConnection.php';
    class Validate{

        public static function validatePass($username,$password){
            DBAccess::escape_input(array($username,$password));
            $result=DBAccess::query("SELECT password FROM utenti WHERE username = '$username' ",true);
            if($result){
                $result=$result[0];
                if($password == $result){
                 return true;
                }
            }else{
                    return false;
                }
            
        }

        
    }
?>