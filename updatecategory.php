<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
include "dbconn.php";
include "header.php";
$categorynamevalue = "";
$categoryidvalue = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categorynamevalue = test_input($_POST["updatecategoryname"]);
    $categoryidvalue = test_input($_POST["updatethiscategoryid"]);
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
$ConnHandigelinksDB -> autocommit(FALSE);
$sql = "UPDATE tblCategorien SET Categorienaam = '$categorynamevalue' WHERE CategorieID = '$categoryidvalue'";
$ConnHandigelinksDB -> query($sql);
if (!$ConnHandigelinksDB -> commit()) {
    echo "Commit transaction failed";
    exit();
  }
header("location:index.php");

$ConnHandigelinksDB -> close();
?>