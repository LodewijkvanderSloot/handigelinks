<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
include "dbconn.php";
include "header.php";
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $linkid = test_input($_GET["linkid"]);
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

    <body>
        <ul class="menu">
            <li class="actief"><a href=index.php>Handige Links</a></li>
            <li class="menu"><a href="settings.php">Instellingen</a></li>
            <li class="menu"><a href="newcategory.php">Nieuwe Categorie</a></li>
            <li class="menu"><a href="newlink.php">Nieuwe link</a></li>
        </ul>
        <form method="post" action="updatelink.php" id="updatelinkform">
            <input type="hidden" value="<?php echo($linkid); ?>" name="updatethislinkid" id="updatethislinkid">
            <table>
<?php
$sql = "SELECT Linknaam,Link,Favicon,CategorieID FROM tblLinks WHERE LinkID = '$linkid'";
if ($linkresult = $ConnHandigelinksDB -> query($sql)) {
    while ($link = $linkresult -> fetch_object()) {
?>

                <tr>
                    <td><label for="newlinkname">Naam van de nieuwe link:</label></td>
                    <td><input type="text" name="updatelinkname" value="<?php echo($link->Linknaam); ?>"></td>
                </tr>
                <tr>
                    <td><label for="newurl">url van de nieuwe link:</label></td>
                    <td><input type="text" name="updateurl" value="<?php echo($link->Link); ?>"></td>
                </tr>
                <tr>
                    <td><label for="updatefavicon">url voor favicon:</label></td>
                    <td><input type="text" name="updatefavicon" value="<?php echo($link->Favicon) ?>"></td>
                </tr>
                <tr>
                    <td><label for="updatecategory">Categorie:</label></td>
                    <td>
                        <select name="updatecategory" form="updatelinkform">
                        <?php
                            if ($Categorieresult = $ConnHandigelinksDB -> query("SELECT CategorieID,Categorienaam FROM tblCategorien ORDER BY Categorienaam")) {
                                while ($Categorie = $Categorieresult -> fetch_object()) {
                                    if ($link->CategorieID == $Categorie->CategorieID) {
                                        ?>
                                        <option value="<?php echo($Categorie->CategorieID); ?>" selected><?php echo($Categorie->Categorienaam) ?></option>
                                        <?php
                                    } else {
                                        ?>
                                        <option value="<?php echo($Categorie->CategorieID); ?>"><?php echo($Categorie->Categorienaam) ?></option>
                                        <?php
                                    }
                                }
                                $Categorieresult -> free_result();
                            }
                        ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align:right"><input type="submit"></td>
                </tr>

<?php
    }
    $linkresult -> free_result();
}
?>


            </table>
            
        </form>
    </body>
</html>
<?php
$ConnHandigelinksDB -> close();
?>