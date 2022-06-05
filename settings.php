<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
include "header.php";
include "lang.php";
$PersoonID = $_SESSION["id"]
?>

    <body>
        <ul class="menu">
            <li class="actief"><a href=index.php>Handige Links</a></li>
            <li class="menu"><a href="logoff.php">Afmelden</a></li>
            <li class="menu"><a href="chpw.php">Wachtwoord wijzigen</a></li>
            <li class="menu"><a href="newcategory.php">Nieuwe Categorie</a></li>
            <li class="menu"><a href="newlink.php">Nieuwe link</a></li>
        </ul>
      Hier moeten dingen komen als Kleur kiezen, Admin maken en taal kiezen. 
    </body>
</html>
<?php
$ConnHandigelinksDB -> close();
?>
