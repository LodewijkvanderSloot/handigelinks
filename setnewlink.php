<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
include "dbconn.php";
include "header.php";
$linknamevalue = "";
$urlvalue = "";
$faviconvalue = "";
$CategorieIDValue = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $linknamevalue = test_input($_POST["newlinkname"]);
    $urlvalue = test_input($_POST["newurl"]);
    $faviconvalue = test_input($_POST["newfavicon"]);
    $CategorieIDValue = test_input($_POST["newcategory"]);
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$ConnHandigelinksDB -> autocommit(FALSE);
$sql = "INSERT INTO tblLinks (Linknaam,Link,Favicon,CategorieID) VALUES ('$linknamevalue', '$urlvalue', '$faviconvalue', '$CategorieIDValue')";
$ConnHandigelinksDB -> query($sql);
if (!$ConnHandigelinksDB -> commit()) {
    echo "Commit transaction failed";
    exit();
  }
header("location:index.php");
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