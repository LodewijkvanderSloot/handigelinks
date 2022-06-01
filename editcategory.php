<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
include "dbconn.php";
include "header.php";
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
            <li class="actief"><a href=index.php>Handige Links</a></li>
            <li class="menu"><a href="settings.php">Instellingen</a></li>
            <li class="menu"><a href="newcategory.php">Nieuwe Categorie</a></li>
            <li class="menu"><a href="newlink.php">Nieuwe link</a></li>
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
                    <td><label for="updatecategoryform">Naam van de categorie:</label></td>
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
    </body>
</html>
<?php
$ConnHandigelinksDB -> close();
?>