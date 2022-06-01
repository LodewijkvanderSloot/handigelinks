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
?>

    <body>
        <ul class="menu">
            <li class="actief"><a href=chpw.php>Wijzig wachtwoord</a></li>
            <li class="menu"><a href="index.php">Handige Links</a></li>
        </ul>
        <form method="post" action="setnewpw.php" id="newpwform">
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
            </table>
            
        </form>
    </body>
</html>
<?php
$ConnHandigelinksDB -> close();
?>
