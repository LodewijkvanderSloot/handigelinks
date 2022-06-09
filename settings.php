<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
include "header.php";
include "lang.php";
$PersoonID = $_SESSION["id"]
?>

    <body>
        <ul class="menu">
            <li class="actief"><a href=index.php>Handige Links</a></li>
            <li class="menu"><a href="logoff.php">Afmelden</a></li>
            <li class="menu"><a href="chpw.php">Wachtwoord wijzigen</a></li>
            <li class="menu"><a href="newcategory.php">Nieuwe Categorie</a></li>
            <li class="menu"><a href="newlink.php">Nieuwe link</a></li>
        </ul>
        <h1>Site settings</h1>
        <form method = "post" action = "setsitesetting.php" id="sitesettingsform">
            <table>
                <tr>
                    <td><h2>ID</h2></td>
                    <td><h2>Name</h2></td>
                    <td><h2>Value<h2</td>
                </tr>
                <tr>
                    <td><p>1</p></td>
                    <td><input type="text" name="input1" value="Title"></td>
                    <td><input type="text" name="input1Value" value="Handige Links"></td>
                </tr>
                <tr>
                    <td><p>2</p></td>
                    <td><input type="text" name="input2" value="Version"></td>
                    <td><input type="text" name="input2Value" value="2.0"></td>
                </tr>
                <tr>
                    <td><p>3</p></td>
                    <td><input type="text" name="input3" value="Language"></td>
                    <td><input type="text" name="input3Value" value="EN"></td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align:right"><input type="submit" value="Update all this settings now!"></td>
                </tr>
            </table>
        </form>

      <p>Hier moeten dingen komen als Kleur kiezen, Admin maken en taal kiezen. </p>
    </body>
</html>
<?php
$ConnHandigelinksDB -> close();
?>
