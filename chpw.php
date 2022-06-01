<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
include "dbconn.php";
include "header.php";
$persoonid = "";
$persoonid = $_SESSION["id"];
$loginnamevalue = "";
$passwordvalue = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $oldpassword = test_input($_POST["oldpw"]);
    $newpassword1 = test_input($_POST["newpw1"]);
    $newpassword2 = test_input($_POST["wachtwoord"]);
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
//test if new passwords match
if ($newpassword1 == $newpassword2 {
    //test if new password is different
    if (newpassword1 == $oldpassword) {
        $foutje = "Wachtwoord mag niet hetzelfde zijn."
    } else {
        //Doe dingen met wijzigen van het wachtwoord. 
} else {
   $foutje = "Nieuwe wachtwoorden zijn niet hetzelfde."
}
?>

    <body>
        <ul class="menu">
            <li class="actief"><a href=chpw.php>Wijzig wachtwoord</a></li>
            <li class="menu"><a href="index.php">Handige Links</a></li>
        </ul>
        <form method="post" action="chpw.php" id="newpwform">
            <table>
                <tr>
                    <td><label for="oldpw">Oude wachtwoord:</label></td>
                    <td><input type="password" name="oldpw"></td>
                </tr>
                <tr>
                    <td><label for="newpw1">Nieuw wachtwoord:</label></td>
                    <td><input type="password" name="newpw1"></td>
                </tr>
                <tr>
                    <td><label for="newpw2">Herhaal nieuwe wachtwoord:</label></td>
                    <td><input type="password" name="newpw2"></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align:right"><input type="submit"></td>
                </tr>
                <tr>
                    <td colspan="2"><span class="help_block"><?php echo $foutje; ?></span></td>
                </tr>
            </table>
            
        </form>
    </body>
</html>
<?php
$ConnHandigelinksDB -> close();
?>
