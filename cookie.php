<?php

session_start();

//No Cookie No Session -> Login
if(!isset($_COOKIE["Koekjes"])){
    Echo "Er is helemaal geen cookie<br>";
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        //header("location: login.php");
        echo "Er is niet ingelogd<br>";
        exit;
    }
} 
//Cookie no session -> Make session
if (isset($_COOKIE["Koekjes"])){
    echo "Er is een koekje<br>Sessie:";
    echo $_SESSION["id"];
    echo "<br>cookie:";
    echo $_COOKIE["Koekjes"];


    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        echo "Er is niet ingelogd<br>Sessie in elkaar klussen";
        $_SESSION["loggedin"] = true;
        $_SESSION["id"] = $_COOKIE["Koekjes"];
        setcookie("Koekjes", $_SESSION["id"], time()+60480);
    }
    //setcookie("Koekjes", $_SESSION["id"], time()+60480);
} 
if(isset($_COOKIE["Koekje"]) && $_SESSION["loggedin"]===true) {
    Echo "Er is een cookie en er is ingelogd. Cookie verversen";
    setcookie("Koekjes", $_SESSION["id"], time()+60480);
    echo $_COOKIE["Koekjes"];
}
?>
