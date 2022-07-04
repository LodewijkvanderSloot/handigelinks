<?php
include "checklogin.php";
include "dbconn.php";
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
$sqllog = "INSERT INTO tblLogs (PersoonID,Log) VALUES ('$persoonid','New public category $categoryvalue made.')";
$ConnHandigelinksDB -> query($sqllog);
if (!$ConnHandigelinksDB -> commit()) {
    echo "Commit transaction failed";
    exit();
}
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
