<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
include "dbconn.php";
include "header.php";
include "lang.php";
$PersoonID = $_SESSION["id"]
?>

    <body>
        <ul class="menu">
            <li class="actief"><a href=index.php><?php echo $hanlinkvar; ?></a></li>
            <li class="menu"><a href="logoff.php"><?php echo $logoffvar; ?></a></li>
            <li class="menu"><a href="newcategory.php"><?php echo $newcatvar; ?></a></li>
            <li class="menu"><a href="newlink.php"><?php echo $newlinkvar; ?></a></li>
            <?php
            $sql = "SELECT IsAdmin FROM tblPersonen WHERE PersoonID = '$PersoonID'";
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
        <?php
        if ($Categorieresult = $ConnHandigelinksDB -> query("SELECT CategorieID,Categorienaam,PersoonID FROM tblCategorien WHERE PersoonID = '$PersoonID' OR PersoonID = '0'  ORDER BY Categorienaam")) {
            while ($Categorie = $Categorieresult -> fetch_object()) {
                $sql="SELECT LinkID,Linknaam,Link,Favicon FROM tblLinks WHERE CategorieID ='$Categorie->CategorieID'";
                if ($linkresult = $ConnHandigelinksDB -> query($sql)) {
                    

                ?>
                <table width="100%">
                    <tr>
                        <?php
                        if ($Categorie->PersoonID == $PersoonID) { ?>
                            <td width="25%"><h1><?php echo($Categorie->Categorienaam); ?></h1></td>
                        <?php } else { ?>
                            <td width="25%"><h1><?php echo($Categorie->Categorienaam); ?> <?php echo $publicvar; ?></h1></td>
                        <?php } ?>
                        <td style="padding-right:15px;text-align:right" width="75%"><a href="editcategory.php?categoryid=<?php echo($Categorie->CategorieID); ?>" class="small"><b><?php echo $editvar; ?><b></a>
                        <?php
                        if ($linkresult->num_rows == 0) { 
                            ?>
                            <a href="deletecategory.php?categoryid=<?php echo($Categorie->CategorieID); ?>" class="small"><b><?php echo $deletevar; ?><b></a>
                            <?php
                        }
                        ?>
                    </tr>
                </table>
                <hr>
              <table width="100%">
              <?php
              
                  while ($link = $linkresult -> fetch_object()) {
                      ?>
                      <tr>
                          <td><a href="<?php echo($link->Link); ?>" target="_blank"><img src="<?php echo($link->Favicon); ?>" style="width:16px;height:16px"></a></td>
                          <td width="25%"><a href="<?php echo($link->Link); ?>" target="_blank"><?php echo($link->Linknaam); ?></a></td>
                          <td style="padding-right:15px;text-align:right" width="75%"><a href="editlink.php?linkid=<?php echo($link->LinkID); ?>" class="small"><?php echo $editvar; ?></a><a href="deletelink.php?linkid=<?php echo($link->LinkID); ?>" class="small"><?php echo $deletevar; ?></a></td>
                      </tr>
                      <?php
                  }
              $linkresult -> free_result();
              }
              ?>
              </table>
              <?php
            }
            $Categorieresult -> free_result();
          } 
          ?>
    </body>
</html>
<?php
$ConnHandigelinksDB -> close();
?>
