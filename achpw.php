<?php
include "checklogin.php";
include "dbconn.php";
$persoonid = "";
$persoonid = $_SESSION["id"];
$isAdmin = "";
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
$username = "";
$username = $_POST["ThisUser"];
$newpw1 = $_POST["newpw1"];
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $sql = "SELECT * FROM tblPersonen WHERE PersoonID='$username'";
    echo $sql;
    echo "<br>";
    if ($userresult = $ConnHandigelinksDB -> query($sql)) {
        while ($user = $userresult -> fetch_object()) {
            $userloginname = $user -> PersoonLoginnaam;
            echo $userloginname;
            echo "<br>";
        }
    }
    $param_password = password_hash($newpw1, PASSWORD_DEFAULT);
    $ConnHandigelinksDB -> autocommit(FALSE);
    $sql = "UPDATE tblPersonen SET PersoonWachtwoord = '$param_password' WHERE PersoonID = '$username'";
    echo $sql;
    $ConnHandigelinksDB -> query($sql);
    if (!$ConnHandigelinksDB -> commit()) {
        echo "Commit transaction failed";
        exit();
    }
    
    $sqllog = "INSERT INTO tblLogs (PersoonID,Log) VALUES ('$persoonid','Changed password for $userloginname.')";
    $ConnHandigelinksDB -> query($sqllog);
    if (!$ConnHandigelinksDB -> commit()) {
        echo "Commit transaction failed";
        exit();
    }
    header("location: settings.php");
}
$ConnHandigelinksDB -> close();
?>
