<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
include "dbconn.php";
include "header.php";
$categoryidvalue = "";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $categoryidvalue = test_input($_GET["categoryid"]);
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
$ConnHandigelinksDB -> autocommit(FALSE);
$sql = "DELETE FROM tblCategorien WHERE CategorieID = '$categoryidvalue'";
echo($sql);
$ConnHandigelinksDB -> query($sql);
if (!$ConnHandigelinksDB -> commit()) {
    echo "Commit transaction failed";
    exit();
  }
header("location:index.php");

$ConnHandigelinksDB -> close();
?>