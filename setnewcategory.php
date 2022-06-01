<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
include "dbconn.php";
include "header.php";
$categoryvalue = "";
$persoonid = '';
$persoonid = $_SESSION["id"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categoryvalue = test_input($_POST["newcatname"]);
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
$ConnHandigelinksDB -> autocommit(FALSE);
if (isset($_POST["public"])){
$sql = "INSERT INTO tblCategorien (Categorienaam,PersoonID) VALUES ('$categoryvalue','0')";
} else {
$sql = "INSERT INTO tblCategorien (Categorienaam,PersoonID) VALUES ('$categoryvalue','$persoonid')";
}
$ConnHandigelinksDB -> query($sql);
if (!$ConnHandigelinksDB -> commit()) {
    echo "Commit transaction failed";
    exit();
  }
header("location:newcategory.php");
?>

    <body>
        <ul class="menu">
            <li class="menu"><a href=index.php>Handige Links</a></li>
            <li class="menu"><a href="settings.php">Instellingen</a></li>
            <li class="actief"><a href="newcategory.php">Nieuwe Categorie</a></li>
            <li class="menu"><a href="newlink.php">Nieuwe link</a></li>
        </ul>
        <p>Catergorie toegevoegd.</p>
    </body>
</html>
<?php
$TitleResult -> close();
$BGColorResult -> close();
$ConnHandigelinksDB -> close();
?>
