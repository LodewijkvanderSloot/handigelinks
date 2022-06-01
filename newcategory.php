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
            <li class="actief"><a href="newcategory.php">Nieuwe Categorie</a></li>
            <li class="menu"><a href="newlink.php">Nieuwe link</a></li>
        </ul>
        <form method="post" action="setnewcategory.php">
            <label for="newcatname">Nieuwe categorienaam:</label>
            <input type="text" name="newcatname">
            <input type="submit">
        </form>
        <p>De huidige lijst categoriën</p>
        <ul>
        <?php
        if ($Categorieresult = $ConnHandigelinksDB -> query("SELECT Categorienaam FROM tblCategorien WHERE PersoonID = '$persoonid' ORDER BY Categorienaam")) {
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