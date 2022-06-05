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
            <li class="menu"><a href="chpw.php"><?php echo $chpwvar; ?></a></li>
            <li class="actief"><a href="newcategory.php"><?php echo $newcatvar; ?></a></li>
            <li class="menu"><a href="newlink.php"><?php echo $newlinkvar; ?></a></li>
            <li class="menu"><a href=index.php><?php echo $hanlinkvar; ?></a></li>
            <?php
            $sql = "SELECT IsAdmin FROM tblPersonen WHERE PersoonID = '$persoonid'";
            if ($adminresult = $ConnHandigelinksDB -> query($sql)) {
                while ($admin = $adminresult -> fetch_object()) {
                    if ($admin->IsAdmin == 1) {
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
            <label for="newcatname"><?php echo $newcatlbl; ?></label>
            <input type="text" name="newcatname"><br>
            <label for="public"><?php echo $newcatpublbl; ?></label>
            <input type="checkbox" name="public"><br>
            <p><input type="submit">
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
