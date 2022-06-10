<?php
include "checklogin.php";
include "header.php";
include "dbconn.php";
include "lang.php";
$persoonid = "";
$persoonid = $_SESSION["id"];
?>

    <body>
        <ul class="menu">
            <li class="menu"><a href="logoff.php"><?php echo $logoffvar; ?></a></li>
            <li class="menu"><a href="chpw.php"><?php echo $chpwvar; ?></a></li>
            <li class="actief"><a href="newcategory.php"><?php echo $newcatvar; ?></a></li>
            <li class="menu"><a href="newlink.php"><?php echo $newlinkvar; ?></a></li>
            <li class="menu"><a href=index.php><?php echo $hanlinkvar; ?></a></li>
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
        <form method="post" action="setnewcategory.php">
            <table>
                <tr>
                    <td><label for="newcatname"><?php echo $newcatlbl; ?></label></td>
                    <td><input type="text" name="newcatname"></td>
                </tr>
                <?php 
                if ($isAdmin == 'admin') {
                ?>
                <tr>
                    <td><label for="public"><?php echo $newcatpublbl; ?></label></td>
                    <td><input type="checkbox" name="public"></td>
                </tr>
                <?php
                }
                ?>
                <tr>
                    <td colspan ="2" style="text-align:right"><input type="submit"></td>
                </tr>
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
