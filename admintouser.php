<?php
include "checklogin.php";
include "dbconn.php";
$PersoonIDvalue = "";
$persoonid = $_SESSION["id"];
$sql = "SELECT IsAdmin FROM tblPersonen WHERE PersoonID = '$persoonid'";
if ($adminresult = $ConnHandigelinksDB -> query($sql)) {
    while ($admin = $adminresult -> fetch_object()) {
        if ($admin->IsAdmin == 1) {
            $isAdmin = 'admin';
        } else {
            header("location:index.php");
        }
    }
}
$PersoonIDvalue = $_POST["ThisUser"];
if ($persoonid == $PersoonIDvalue) {
    echo "dacht het niet...";
} else {
    $ConnHandigelinksDB -> autocommit(FALSE);
    $sql = "UPDATE tblPersonen SET isAdmin = NULL WHERE PersoonID = $PersoonIDvalue";
    $ConnHandigelinksDB -> query($sql);
    if (!$ConnHandigelinksDB -> commit()) {
        echo "Commit transaction failed";
        exit();
    }
}
$ConnHandigelinksDB -> close();
header("location:settings.php");
?>