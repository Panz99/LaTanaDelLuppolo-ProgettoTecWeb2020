<?php
session_start();
unset($_SESSION['id']);
unset($_SESSION['logged']);
header('Location: home.php');
?>