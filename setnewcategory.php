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
header("location:index.php");
$TitleResult -> close();
$BGColorResult -> close();
$ConnHandigelinksDB -> close();
?>
