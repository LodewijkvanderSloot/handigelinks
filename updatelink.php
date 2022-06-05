<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
include "dbconn.php";
$linknamevalue = "";
$urlvalue = "";
$faviconvalue = "";
$CategorieIDValue = "";
$linkidvalue = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $linknamevalue = test_input($_POST["updatelinkname"]);
    $urlvalue = test_input($_POST["updateurl"]);
    $faviconvalue = test_input($_POST["updatefavicon"]);
    $CategorieIDValue = test_input($_POST["updatecategory"]);
    $linkidvalue = test_input($_POST["updatethislinkid"]);
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
$ConnHandigelinksDB -> autocommit(FALSE);
$sql = "UPDATE tblLinks SET Linknaam = '$linknamevalue',Link = '$urlvalue', Favicon = '$faviconvalue', CategorieID = '$CategorieIDValue' WHERE LinkID = '$linkidvalue'";
$ConnHandigelinksDB -> query($sql);
if (!$ConnHandigelinksDB -> commit()) {
    echo "Commit transaction failed";
    exit();
  }
header("location:index.php");
$ConnHandigelinksDB -> close();
?>