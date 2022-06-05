<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
include "dbconn.php";
include "header.php";
include "lang.php";
$persoonid = "";
$persoonid = $_SESSION["id"];
?>

    <body>
        <ul class="menu">
            <li class="menu"><a href="logoff.php"><?php echo $logoffvar; ?></a></li>
            <li class="menu"><a href="newcategory.php"><?php echo $newcatvar; ?></a></li>
            <li class="actief"><a href="newlink.php"><?php echo $newlinkvar; ?></a></li>
            <li class="menu"><a href=index.php><?php echo $hanlinkvar; ?></a></li>
        </ul>
        <form method="post" action="setnewlink.php" id="newlinkform">
            <table>
                <tr>
                    <td><label for="newlinkname"><?php echo $linknamelbl; ?></label></td>
                    <td><input type="text" name="newlinkname"></td>
                </tr>
                <tr>
                    <td><label for="newurl"><?php echo $linkaddrlbl; ?></label></td>
                    <td><input type="text" name="newurl"></td>
                </tr>
                <tr>
                    <td><label for="newfavicon"><?php echo $favicoaddrlbl; ?></label></td>
                    <td><input type="text" name="newfavicon"></td>
                </tr>
                <tr>
                    <td><label for="newcategory"><?php echo $catlbl; ?></label></td>
                    <td>
                        <select name="newcategory" form="newlinkform">
                        <?php
                            if ($Categorieresult = $ConnHandigelinksDB -> query("SELECT CategorieID,Categorienaam FROM tblCategorien WHERE PersoonID = '$persoonid' OR PersoonID = '0' ORDER BY Categorienaam")) {
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
