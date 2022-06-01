<?php
$DBServer = "localhost";
$DBUser = "adminlodewijk";
$DBPassword = "Gewijzigd2020";
$DBDatabase = "HandigeLinks";
$ConnHandigelinksDB = new mysqli($DBServer,$DBUser,$DBPassword,$DBDatabase);
if ($ConnHandigelinksDB -> connect_errno) {
    echo "Failed to connect to MySQL: " . $ConnHandigelinksDB -> connect_error;
    exit();
  }
?>