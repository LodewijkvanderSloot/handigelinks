<?php
include "dbconn.php";
if ($settingResult = $ConnHandigelinksDB -> query("SELECT SettingValue FROM tblSettings WHERE SettingID = '1'")) {
    While ($setting = $settingResult -> fetch_object()) {
        $titlename = $setting -> SettingValue;
    }
    $settingResult -> free_result();
}if ($settingResult = $ConnHandigelinksDB -> query("SELECT SettingValue FROM tblSettings WHERE SettingID = '2'")) {
    While ($setting = $settingResult -> fetch_object()) {
        $version = $setting -> SettingValue;
    }
    $settingResult -> free_result();
}
if ($settingResult = $ConnHandigelinksDB -> query("SELECT SettingValue FROM tblSettings WHERE SettingID = '4'")) {
    While ($setting = $settingResult -> fetch_object()) {
        $bgcolor = $setting -> SettingValue;
    }
    $settingResult -> free_result();
}
if ($settingResult = $ConnHandigelinksDB -> query("SELECT SettingValue FROM tblSettings WHERE SettingID = '5'")) {
    While ($setting = $settingResult -> fetch_object()) {
        $fgcolor = $setting -> SettingValue;
    }
    $settingResult -> free_result();
}
?>
<html>
    <header>
        <title><?php echo $titlename; ?> <?php echo $version; ?></title>
        <style type="text/css">
            body {background-color:<?php echo $bgcolor; ?>; margin: 0px}
            h1 {font-family: Corbel; font-size: 12pt; font-weight: bold; color: <?php echo $fgcolor; ?>; margin-bottom:0px; margin-left: 5px}
            h2 {font-family: Corbel; font-size: 12pt; font-weight: normal; color: <?php echo $fgcolor; ?>; margin-bottom:0px; margin-left: 5px}
            hr {border-top:0;border-bottom:1px solid <?php echo $fgcolor; ?>;margin-top:0px}
            a {font-family: Corbel; font-size: 10pt; font-weight: normal; color: <?php echo $fgcolor; ?>; margin-left:20px}
            a:hover {font-family: Corbel; font-size: 10pt; font-weight: normal; color: black; margin-left:20px}
            ul.menu {background-color: <?php echo $fgcolor; ?>;list-style-type: none;overflow: hidden; position: sticky;top: 0px;}
            li.menu {float:right}
            li.menu a {display: block; font-family: corbel; font-size: 12pt; font-weight: bold;padding: 10px;text-decoration: none; color: <?php echo $bgcolor; ?>;}
            li.actief {float:left}
            li.actief a {display: block; font-family: corbel; font-size: 12pt; font-weight: bold;padding: 10px;text-decoration: none; color: <?php echo $fgcolor; ?>; background-color: <?php echo $bgcolor; ?>;}
            p {font-family: Corbel; font-size: 10pt; font-weight: normal; color: <?php echo $fgcolor; ?>; margin-left:20px}
            ul {font-family: Corbel; font-size: 10pt; font-weight: normal; color: <?php echo $fgcolor; ?>;}
            label {font-family: corbel; font-size: 12pt; font-weight: bold;color: <?php echo $fgcolor; ?>; margin-left: 20px}
            a.small {text-align:right; font-family:corbel; font-size:8pt; color:<?php echo $fgcolor; ?>; text-decoration:none;margin-left:5px}
            a.small:hover {text-align:right; font-family:corbel; font-size:8pt; color:black; text-decoration:none;margin-left:5px}
            .help-block {color:red;font-variant: small-caps;font-family:corbel;font-size:10pt}
            .form-group {margin-bottom: 5px;border:1px solid purple;width:500px}
        </style>
    </header>