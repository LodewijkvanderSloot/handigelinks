<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
include "dbconn.php";
include "header.php";
$PersoonID = $_SESSION["id"]
?>

    <body>
        <ul class="menu">
            <li class="actief"><a href=index.php>Handige Links</a></li>
            <li class="menu"><a href="logoff.php">Afmelden</a></li>
            <li class="menu"><a href="newcategory.php">Nieuwe Categorie</a></li>
            <li class="menu"><a href="newlink.php">Nieuwe link</a></li>
        </ul>
        <?php
        if ($Categorieresult = $ConnHandigelinksDB -> query("SELECT CategorieID,Categorienaam,PersoonID FROM tblCategorien WHERE PersoonID = '$PersoonID' ORDER BY Categorienaam")) {
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
                            <td width="25%"><h1><?php echo($Categorie->Categorienaam); ?> (Publiek)</h1></td>
                        <?php } ?>
                        <td style="padding-right:15px;text-align:right" width="75%"><a href="editcategory.php?categoryid=<?php echo($Categorie->CategorieID); ?>" class="small"><b>Bewerken<b></a>
                        <?php
                        if ($linkresult->num_rows == 0) { 
                            ?>
                            <a href="deletecategory.php?categoryid=<?php echo($Categorie->CategorieID); ?>" class="small"><b>Verwijderen<b></a>
                            <?php
                        }
                        ?>
                    </tr>
                </table>
                <hr>
                <?php
              //printf("<h1>%s<small style='text-align:right;text-decoration:none;font-size:8pt'>test</small></h1><hr>", $Categorie->Categorienaam);
              
              //echo $sql;
              ?>

              <table width="100%">
              <?php
              
                  while ($link = $linkresult -> fetch_object()) {
                      ?>
                      <tr>
                          <td><a href="<?php echo($link->Link); ?>" target="_blank"><img src="<?php echo($link->Favicon); ?>" style="width:16px;height:16px"></a></td>
                          <td width="25%"><a href="<?php echo($link->Link); ?>" target="_blank"><?php echo($link->Linknaam); ?></a></td>
                          <td style="padding-right:15px;text-align:right" width="75%"><a href="editlink.php?linkid=<?php echo($link->LinkID); ?>" class="small">Bewerken</a><a href="deletelink.php?linkid=<?php echo($link->LinkID); ?>" class="small">Verwijderen</a></td>
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
