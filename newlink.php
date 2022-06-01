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
            <li class="menu"><a href=index.php>Handige Links</a></li>
            <li class="menu"><a href="newcategory.php">Nieuwe Categorie</a></li>
            <li class="actief"><a href="newlink.php">Nieuwe link</a></li>
        </ul>
        <form method="post" action="setnewlink.php" id="newlinkform">
            <table>
                <tr>
                    <td><label for="newlinkname">Naam van de nieuwe link:</label></td>
                    <td><input type="text" name="newlinkname"></td>
                </tr>
                <tr>
                    <td><label for="newurl">url van de nieuwe link:</label></td>
                    <td><input type="text" name="newurl"></td>
                </tr>
                <tr>
                    <td><label for="newfavicon">url voor favicon:</label></td>
                    <td><input type="text" name="newfavicon"></td>
                </tr>
                <tr>
                    <td><label for="newcategory">Categorie:</label></td>
                    <td>
                        <select name="newcategory" form="newlinkform">
                        <?php
                            if ($Categorieresult = $ConnHandigelinksDB -> query("SELECT CategorieID,Categorienaam FROM tblCategorien WHERE PersoonID = '$persoonid' ORDER BY Categorienaam")) {
                                while ($Categorie = $Categorieresult -> fetch_object()) {
                                    printf('<option value="%s";>%s</option>',$Categorie->CategorieID,$Categorie->Categorienaam);
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
            </table>
            
        </form>
    </body>
</html>
<?php
$ConnHandigelinksDB -> close();
?>