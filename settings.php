<?php
include "checklogin.php";
include "header.php";
include "dbconn.php";
include "lang.php";
$persoonid = "";
$persoonid = $_SESSION["id"];
$isAdmin = "";
$sql = "SELECT IsAdmin FROM tblPersonen WHERE PersoonID = '$persoonid'";
if ($adminresult = $ConnHandigelinksDB -> query($sql)) {
    while ($admin = $adminresult -> fetch_object()) {
        if ($admin->IsAdmin == 1) {
            $isAdmin = 'admin';
        } else {
            header("location:index.php");
        }
    }
}

?>

    <body>
        <ul class="menu">
            <li class="menu"><a href="logoff.php"><?php echo $logoffvar; ?></a></li>
            <li class="menu"><a href="chpw.php"><?php echo $chpwvar; ?></a></li>
            <li class="menu"><a href="newcategory.php"><?php echo $newcatvar; ?></a></li>
            <li class="menu"><a href="newlink.php"><?php echo $newlinkvar; ?></a></li>
            <li class="menu"><a href=index.php><?php echo $hanlinkvar; ?></a></li>
            <li class="actief"><a href="settings.php"><?php echo $settingsvar; ?></a></li>
        </ul>
        <h1>Log</h1>
        <table>
            <tr>
                <td><p><b>nr.</b></p></td>
                <td><p><b>Datum</b></p></td>
                <td><p><b>Wie</b></p></td>
                <td><p><b>Actie</b></p></td>
                <?php
                    $sql = "SELECT tblLogs.LogID,tblLogs.Date,tblLogs.PersoonID,tblLogs.Log,tblPersonen.PersoonID,tblPersonen.PersoonLoginnaam FROM tblLogs INNER JOIN tblPersonen ON tblLogs.PersoonID = tblPersonen.PersoonID ORDER BY tblLogs.Date DESC LIMIT 15";
                    if($logresult = $ConnHandigelinksDB -> query($sql)) {
                        while ($log = $logresult -> fetch_object()) {
                            ?>
                <tr>
                    <td><p><?php echo $log -> LogID; ?></td>
                    <td><p><?php echo $log -> Date; ?></td>
                    <td><p><?php echo $log -> PersoonLoginnaam; ?></td>
                    <td><p><?php echo $log -> Log; ?></td>
                </tr>
                            <?php
                        }
                    }
                ?>
            </tr>
        </table>
        <hr>
        <h1>Site settings</h1>
        <form method = "post" action = "setsitesetting.php" id="sitesettingsform">
            <table>
                <tr>
                    <td><h2>ID</h2></td>
                    <td><h2>Name</h2></td>
                    <td><h2>Value<h2</td>
                </tr>
                <tr>
                    <td><p>1</p></td>
                    <td><input type="text" name="input1" value="Title"></td>
                    <td><input type="text" name="input1Value" value="Handige Links"></td>
                </tr>
                <tr>
                    <td><p>2</p></td>
                    <td><input type="text" name="input2" value="Version"></td>
                    <td><input type="text" name="input2Value" value="2.0"></td>
                </tr>
                <tr>
                    <td><p>3</p></td>
                    <td><input type="text" name="input3" value="Language"></td>
                    <td><input type="text" name="input3Value" value="EN"></td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align:right"><input type="submit" value="Update all this settings now!"></td>
                </tr>
            </table>
        </form>
        <hr>
        <h1>Nieuwe gebruiker maken</h1>
        <form action="newuser.php" method="post">
            <table>
                <tr>
                    <td><label for="username"><?php echo $namelbl; ?></label></td>
                    <td><input type="text" name="username" value="<?php echo $username; ?>"></td>
                    <td><span class="help-block"><?php echo $username_err; ?></span></td>
                </tr>
                <tr>
                    <td><label for="password"><?php echo $newpwlbl; ?></label></td>
                    <td><input type="password" name="password" value="<?php echo $password; ?>"></td>
                    <td><span class="help-block"><?php echo $password_err; ?></span></td>
                </tr>
                <tr>
                    <td><label for="confirm_password"><?php echo $reppwlbl; ?></label></td>
                    <td><input type="password" name="confirm_password" value="<?php echo $confirm_password; ?>"></td>
                    <td><span class="help-block"><?php echo $confirm_password_err; ?></span></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align:right"><input type="submit"><input type="reset"></td>
                    <td></td>
                </tr>
            </table>
        </form>
        <hr>
        <h1>Maak een gebruiker een Admin</h1>
        <form method="post" action="usertoadmin.php">
            <table>
                <tr>
                    <td>
                        <select name="ThisUser">
                        <?php
                        $sql = "SELECT PersoonLoginnaam,PersoonID FROM tblPersonen WHERE isAdmin IS NULL";
                        if ($userresult = $ConnHandigelinksDB -> query($sql)) {
                            while ($user = $userresult -> fetch_object()) {
                                ?><option value="<?php echo $user->PersoonID; ?>"><?php echo $user->PersoonLoginnaam; ?></option>
                                <?php
                            }
                        }
                        ?>
                        </select>
                    </td>
                    <td>
                        <input type="submit">
                    </td>
                </tr>
            </table>
        </form>
        <hr>
        <h1>Maak een admin een gebruiker</h1>
        <form method="post" action="admintouser.php">
            <table>
                <tr>
                    <td>
                        <select name="ThisUser">
                        <?php
                        $sql = "SELECT PersoonLoginnaam,PersoonID FROM tblPersonen WHERE NOT isAdmin IS NULL AND NOT PersoonID = $persoonid";
                        if ($userresult = $ConnHandigelinksDB -> query($sql)) {
                            while ($user = $userresult -> fetch_object()) {
                                ?><option value="<?php echo $user->PersoonID; ?>"><?php echo $user->PersoonLoginnaam; ?></option>
                                <?php
                            }
                        }
                        ?>
                        </select>
                    </td>
                    <td>
                        <input type="submit">
                    </td>
                </tr>
            </table>
        </form>
        <hr>
        <h1>Wachtwoord wijzigen</h1>
        <form method="post" action="achpw.php">
            <table>
                <tr>
                    <td><label for="oldpw"><?php echo $namelbl; ?></label></td>
                    <td><select name="ThisUser">
                     <?php
                     $sql = "SELECT PersoonLoginnaam,PersoonID FROM tblPersonen ORDER BY PersoonLoginnaam";
                     if ($userresult = $ConnHandigelinksDB -> query($sql)) {
                        while ($user = $userresult -> fetch_object()) {
                            ?><option value="<?php echo $user->PersoonID; ?>"><?php echo $user->PersoonLoginnaam; ?></option>
                            <?php
                        }
                    }
                     ?>   
                    </select></td>
                </tr>
                <tr>
                    <td><label for="newpw1"><?php echo $newpwlbl; ?></label></td>
                    <td><input type="password" name="newpw1"></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align:right"><input type="submit"></td>
                </tr>
            </table>
        </form>
        <hr>


      <p>Hier moeten dingen komen als Kleur kiezen, Admin maken en taal kiezen. </p>
    </body>
</html>
<?php
$ConnHandigelinksDB -> close();
?>
