<?php
session_start();
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}

include "dbconn.php";
include "lang.php";
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

$sql = "SELECT * FROM tblPersonen WHERE PersoonLoginnaam='$loginnamevalue'";
if ($loginresult = $ConnHandigelinksDB -> query($sql)) {
    while ($login = $loginresult -> fetch_object()) {
        $hash = $login->PersoonWachtwoord;
        $validpassword = password_verify($passwordvalue,$hash);
        if ($validpassword) {
            session_start();
            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $login->PersoonID;
            //$_SESSION["username"] = $login->PersoonLoginnaam;
            if (isset($_POST["onthouden"])){
                setcookie("Koekjes", $_SESSION["id"], time()+60480);
            }
            if (!isset($_POST["onthouden"])){
                setcookie("Koekjes", "", time()-3600);
            }
            header("location: index.php");
        } else {$foutje = $errormsg1;}
    }
}
$ConnHandigelinksDB -> close();
include "header.php";
?>

    <body>
    <ul class="menu">
            <li class="menu"><a href=register.php><?php echo $registervar; ?></a></li>
            <li class="actief"><a href="login.php"><?php echo $loginvar; ?></a></li>
        </ul>
        <table>
            <tr>
                <td><h1><?php echo $loginvar; ?></h1></td>
            </tr>
        </table>
        <hr>
        <form method="post" action="login.php">
        <table>
            <tr>
                <td><label for="naam"><?php echo $namelbl; ?></label></td>
                <td><input type="text" name="naam"></td>
            </tr>
            <tr>
                <td><label for="wachtwoord"><?php echo $passwordlbl; ?></label></td>
                <td><input type="password" name="wachtwoord"></td>
            </tr>
            <tr>
                <td><label for="onthouden"><?php echo $remembermelbl; ?></label></td>
                <td><input type="checkbox" name="onthouden"></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:right"><input type="submit"><input type="reset"></td>
            </tr>
            <tr>
                <td colspan="2"><span class="help_block"><?php echo $foutje; ?></span></td>
            </tr>
        </table>
        </form>
    </body>
</html>
<?php
$TitleResult -> close();
$BGColorResult -> close();
$ConnHandigelinksDB -> close();
?>