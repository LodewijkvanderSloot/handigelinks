<?php
include "dbconn.php";
include "header.php";
$loginnamevalue = "";
$passwordvalue = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $loginnamevalue = test_input($_POST["naam"]);
    $passwordvalue = $_POST["wachtwoord"];
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
$hashedpassword = password_hash($password, PASSWORD_BCRYPT);
$ConnHandigelinksDB -> autocommit(FALSE);
$sql = "INSERT INTO tblPersonen (PersoonLoginnaam,PersoonWachtwoord) VALUES ('$loginnamevalue', '$hashedpassword')";
$ConnHandigelinksDB -> query($sql);
if (!$ConnHandigelinksDB -> commit()) {
    echo "Commit transaction failed";
    exit();
  }
header("location:index.php");
?>

    <body>
        <p>Nieuwe persoon toegevoegd.</p>
    </body>
</html>
<?php
$TitleResult -> close();
$BGColorResult -> close();
$ConnHandigelinksDB -> close();
?>