<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}
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

$sql = "SELECT * FROM tblPersonen WHERE PersoonLoginnaam='$loginnamevalue'";
//echo($sql);
if ($loginresult = $ConnHandigelinksDB -> query($sql)) {
    while ($login = $loginresult -> fetch_object()) {
        //echo($login->PersoonLoginnaam);
        //echo("<br>");
        //echo($login->PersoonWachtwoord); 
        $hash = $login->PersoonWachtwoord;
        
        $validpassword = password_verify($passwordvalue,$hash);
        if ($validpassword) {

            session_start();
                            
            // Store data in session variables
            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $login->PersoonID;
            $_SESSION["username"] = $login->PersoonLoginnaam;                            
            
            // Redirect user to welcome page
            header("location: index.php");

        } else {$foutje = "Gebruikersaccount of wachtwoord klopt niet!";}
        echo("<br>");
        /*if (password_verify($passwordvalue,$login->PersoonWachtwoord)) {
            echo("<br>wachtwoord in orde");
        } else {
            echo("<br>ONJUIST WACHTWOORD");
        }*/
    }
}
?>

    <body>
    <ul class="menu">
            <li class="menu"><a href=registreren.php>Registreren</a></li>
            <li class="actief"><a href="login.php">Aanmelden</a></li>
        </ul>
        <table>
            <tr>
                <td><h1>Aanmelden</h1></td>
            </tr>
        </table>
        <hr>
        <form method="post" action="login.php">
        <table>
            <tr>
                <td><label for="naam">Naam:</label></td>
                <td><input type="text" name="naam"></td>
            </tr>
            <tr>
                <td><label for="wachtwoord">Wachtwoord:</label></td>
                <td><input type="password" name="wachtwoord"></td>
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