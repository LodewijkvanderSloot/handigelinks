<?php
include "checklogin.php";
include "dbconn.php";
$linkidvalue = "";
$persoonid = "";
$persoonid = $_SESSION["id"];
$isAdmin = "";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $linkidvalue = test_input($_GET["linkid"]);
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
            $isAdmin = 'admin';
        }
    }
}

$ConnHandigelinksDB -> autocommit(FALSE);
if ($isAdmin == 'admin') {
    $sql = "DELETE FROM tblLinks WHERE LinkID = '$linkidvalue'";
} else {
    $sql = "DELETE tblLinks FROM tblLinks INNER JOIN tblCategorien on tblCategorien.CategorieID = tblLinks.CategorieID AND tblLinks.LinkID = '$linkidvalue' AND tblCategorien.PersoonID = '$persoonid'";
}


$ConnHandigelinksDB -> query($sql);
if (!$ConnHandigelinksDB -> commit()) {
    echo "Commit transaction failed";
    exit();
  }
header("location:index.php");

$ConnHandigelinksDB -> close();
?>