<?php
include "checklogin.php";
include "header.php";
include "dbconn.php";
include "lang.php";
$persoonid = "";
$persoonid = $_SESSION["id"];
$isAdmin = "";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $categoryid = test_input($_GET["categoryid"]);
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
        <li class="menu"><a href="logoff.php"><?php echo $logoffvar; ?></a></li>
            <li class="menu"><a href="chpw.php"><?php echo $chpwvar; ?></a></li>
            <li class="menu"><a href="newcategory.php"><?php echo $newcatvar; ?></a></li>
            <li class="menu"><a href="newlink.php"><?php echo $newlinkvar; ?></a></li>
            <li class="actief"><a href=index.php><?php echo $hanlinkvar; ?></a></li>
            <?php
            $sql = "SELECT IsAdmin FROM tblPersonen WHERE PersoonID = '$persoonid'";
            if ($adminresult = $ConnHandigelinksDB -> query($sql)) {
                while ($admin = $adminresult -> fetch_object()) {
                    if ($admin->IsAdmin == 1) {
                        $isAdmin = 'admin';
                        ?>
                        <li class="menu"><a href="settings.php"><?php echo $settingsvar; ?></a></li>
                        <?php
                    }
                }
                $adminresult -> free_result();
            }
            ?>
        </ul>
        <form method="post" action="updatecategory.php" id="updatecategoryform">
            <input type="hidden" value="<?php echo($categoryid); ?>" name="updatethiscategoryid" id="updatethiscategoryid">
            <table>
<?php
$sql = "SELECT CategorieID,Categorienaam,PersoonID FROM tblCategorien WHERE CategorieID = '$categoryid'";
if ($Categoryresult = $ConnHandigelinksDB -> query($sql)) {
    while ($category = $Categoryresult -> fetch_object()) {
        if ($isAdmin !== 'admin') {
            if ($category -> PersoonID !== $persoonid) {
                header("location:index.php");
            }
        }
?>

                <tr>
                    <td><label for="updatecategoryform"><?php echo $newcatlbl; ?></label></td>
                    <td><input type="text" name="updatecategoryname" value="<?php echo($category->Categorienaam); ?>"></td>
                </tr>
                <?php
                if ($isAdmin == 'admin') { ?>
                <tr>
                    <td><label for="public"><?php echo $newcatpublbl; ?></label></td>
                    <td><input type="checkbox" name="public" <?php if ($category -> PersoonID == 0) { echo "checked"; } ?>></td>
                </tr> <?php
                } 
                
                ?>
                <tr>
                    <td colspan="2" style="text-align:right"><input type="submit"></td>
                </tr>

<?php
    }
    $Categoryresult -> free_result();
}
?>


            </table>
            
        </form>
        <p><?php echo $currentcatsvar; ?></p>
        <ul>
        <?php
        if ($Categorieresult = $ConnHandigelinksDB -> query("SELECT Categorienaam FROM tblCategorien WHERE PersoonID = '$persoonid' OR PersoonID = '0' ORDER BY Categorienaam")) {
            while ($Categorie = $Categorieresult -> fetch_object()) {
                printf("<li>%s</li>",$Categorie->Categorienaam);
            }
            $Categorieresult -> free_result();
        }

        ?>
        </ul>
    </body>
</html>
<?php
$ConnHandigelinksDB -> close();
?>