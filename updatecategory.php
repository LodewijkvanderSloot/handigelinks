<?php
include "checklogin.php";
include "dbconn.php";
$categorynamevalue = "";
$categoryidvalue = "";
$persoonid = $_SESSION["id"];

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
if (isset($_POST["public"])){
    $sql = "UPDATE tblCategorien SET Categorienaam = '$categorynamevalue', PersoonID = '0' WHERE CategorieID = '$categoryidvalue'";
} else{
    $sql = "UPDATE tblCategorien SET Categorienaam = '$categorynamevalue', PersoonID = '$persoonid' WHERE CategorieID = '$categoryidvalue'";
}
$ConnHandigelinksDB -> query($sql);
if (!$ConnHandigelinksDB -> commit()) {
    echo "Commit transaction failed";
    exit();
  }
header("location:index.php");

$ConnHandigelinksDB -> close();
?>