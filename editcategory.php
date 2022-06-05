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
            <li class="menu"><a href="newcategory.php"><?php echo $newcatvar; ?></a></li>
            <li class="menu"><a href="newlink.php"><?php echo $newlinkvar; ?></a></li>
            <li class="actief"><a href=index.php><?php echo $hanlinkvar; ?></a></li>
        </ul>
        <form method="post" action="updatecategory.php" id="updatecategoryform">
            <input type="hidden" value="<?php echo($categoryid); ?>" name="updatethiscategoryid" id="updatethiscategoryid">
            <table>
<?php
$sql = "SELECT CategorieID,Categorienaam FROM tblCategorien WHERE CategorieID = '$categoryid'";
if ($Categoryresult = $ConnHandigelinksDB -> query($sql)) {
    while ($category = $Categoryresult -> fetch_object()) {
?>

                <tr>
                    <td><label for="updatecategoryform"><?php echo $newcatlbl; ?></label></td>
                    <td><input type="text" name="updatecategoryname" value="<?php echo($category->Categorienaam); ?>"></td>
                </tr>
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