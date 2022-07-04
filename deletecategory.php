<?php
include "checklogin.php";
include "dbconn.php";
$categoryidvalue = "";
$persoonid = "";
$persoonid = $_SESSION["id"];
$isAdmin = "";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $categoryidvalue = test_input($_GET["categoryid"]);
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$sql = "SELECT IsAdmin FROM tblPersonen WHERE PersoonID = '$persoonid'";
if ($adminresult = $ConnHandigelinksDB -> query($sql)) {
    while ($admin = $adminresult -> fetch_object()) {
        if ($admin->IsAdmin == 1) {
            $isAdmin = "admin";
        }
    }
}

$sql="SELECT LinkID,Linknaam,Link,Favicon FROM tblLinks WHERE CategorieID ='$categoryidvalue'";
if ($linkresult = $ConnHandigelinksDB -> query($sql)) {
    if ($linkresult->num_rows == 0) { 
        $ConnHandigelinksDB -> autocommit(FALSE);
        if ($isAdmin === "admin") {
            $sql = "SELECT CategorieNaam FROM tblCategorien WHERE CategorieID = '$categoryidvalue'";
            if ($catresult = $ConnHandigelinksDB -> Query($sql)) {
                while ($cat = $catresult -> fetch_object()) {
                    $catname = $cat -> CategorieNaam;
                }
            }
            $sqllog = "INSERT INTO tblLogs (PersoonID,Log) VALUES ('$persoonid','Public category $catname with id $categoryidvalue was deleted.')";
            $ConnHandigelinksDB -> query($sqllog);
            if (!$ConnHandigelinksDB -> commit()) {
                echo "Commit transaction failed";
                exit();
            }
            $sql = "DELETE FROM tblCategorien WHERE CategorieID = '$categoryidvalue'";
        } else {
            $sql = "DELETE FROM tblCategorien WHERE CategorieID = '$categoryidvalue' AND PersoonID = '$persoonid'";
        }
        $ConnHandigelinksDB -> query($sql);
        if (!$ConnHandigelinksDB -> commit()) {
            echo "Commit transaction failed";
            exit();
        }
    }
}
header("location:index.php");

$ConnHandigelinksDB -> close();
?>