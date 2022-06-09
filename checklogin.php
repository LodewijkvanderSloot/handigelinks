<?php
session_start();
if(!isset($_COOKIE["Koekjes"])){
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }
}
if (isset($_COOKIE["Koekjes"])){
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        $_SESSION["loggedin"] = true;
        $_SESSION["id"] = $_COOKIE["Koekjes"];
        setcookie("Koekjes", $_SESSION["id"], time()+60480);
    }
} 
if(isset($_COOKIE["Koekje"]) && $_SESSION["loggedin"]===true) {
    setcookie("Koekjes", $_SESSION["id"], time()+60480);
}
?>