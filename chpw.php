<?php
include "checklogin.php";
include "header.php";
include "dbconn.php";
include "lang.php";
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
                       $foutje = $errpw1;     
                    } elseif(strlen(trim($_POST["newpw1"])) < 6){
                        $foutje = $errpw2;
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
                    $foutje = $errpw3;
                }
            } else {
                $foutje = $errpw4;
            }
        //echo("<br>");
        }
    }
}

?>

    <body>
        <ul class="menu">
            <li class="menu"><a href="logoff.php"><?php echo $logoffvar; ?></a></li>
            <li class="actief"><a href="chpw.php"><?php echo $chpwvar; ?></a></li>
            <li class="menu"><a href="newcategory.php"><?php echo $newcatvar; ?></a></li>
            <li class="menu"><a href="newlink.php"><?php echo $newlinkvar; ?></a></li>
            <li class="menu"><a href=index.php><?php echo $hanlinkvar; ?></a></li>
        </ul>
        <form method="post" action="chpw.php" id="newpwform">
            <table>
                <tr>
                    <td><label for="oldpw"><?php echo $oldpwlbl; ?></label></td>
                    <td><input type="password" name="oldpw"></td>
                </tr>
                <tr>
                    <td><label for="newpw1"><?php echo $newpwlbl; ?></label></td>
                    <td><input type="password" name="newpw1"></td>
                </tr>
                <tr>
                    <td><label for="newpw2"><?php echo $reppwlbl; ?></label></td>
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
