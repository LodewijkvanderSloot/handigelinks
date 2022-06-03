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


// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

$oldpw = $_POST["oldpw"];
$newpw1 = $_POST["newpw1"];
$newpw2 = $_POST["newpw2"];

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    $sql = "SELECT * FROM tblPersonen WHERE PersoonID='$persoonid'";
    //echo($sql);
    if ($loginresult = $ConnHandigelinksDB -> query($sql)) {
        while ($login = $loginresult -> fetch_object()) {
            $hash = $login->PersoonWachtwoord;
            $validpassword = password_verify($oldpw,$hash);
            if ($validpassword) {
            // Nu controleren of nieuwe wachtwoorden matchen
                if ($newpw1 === $newpw2) {
                    // Controleren of wachtwoorden voldoen
                    if(empty(trim($_POST["newpw1"]))){
                       $foutje = "Vul een wachtwoord in. ";     
                    } elseif(strlen(trim($_POST["newpw1"])) < 6){
                        $foutje = "Het wachtwoord moet minimaal 6 tekens bevatten. ";
                    } else {
                    // Ziet er allemaal goed uit. Nieuwe wachtwoord in de database frommelen
                    $param_password = password_hash($newpw1, PASSWORD_DEFAULT);
                    $ConnHandigelinksDB -> autocommit(FALSE);
                    $sql = "UPDATE tblPersonen SET PersoonWachtwoord = '$param_password' WHERE PersoonID = '$persoonid'";
                    //echo ($sql);
                    $ConnHandigelinksDB -> query($sql);
                    if (!$ConnHandigelinksDB -> commit()) {
                        echo "Commit transaction failed";
                        exit();
                    }
                    // Redirect user to welcome page
                    header("location: index.php");
                    }
                } else {
                    $foutje = "Nieuwe wachtwoorden zijn niet hetzelfde!";
                }
            } else {
                $foutje = "Huidige wachtwoord klopt niet!";
            }
        //echo("<br>");
        }
    }
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
$foutje = "";
?>
