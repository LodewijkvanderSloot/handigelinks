<?php
include "checklogin.php";
include "dbconn.php";
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

// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = $erruser1;
    } else{
        // Prepare a select statement
        $sql = "SELECT PersoonID FROM tblPersonen WHERE PersoonLoginnaam = ?";
        
        if($stmt = $ConnHandigelinksDB->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // store result
                $stmt->store_result();
                
                if($stmt->num_rows == 1){
                    $username_err = $erruser2;
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oeps! Er is iets mis gegaan. Probeer het later opnieuw. ";
            }

            // Close statement
            $stmt->close();
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = $errpw1;     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = $errpw2;
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = $errpw5;     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = $errpw3;
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO tblPersonen (PersoonLoginnaam, PersoonWachtwoord) VALUES (?, ?)";
         
        if($stmt = $ConnHandigelinksDB->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ss", $param_username, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){

                $ConnHandigelinksDB -> autocommit(FALSE);
                $sqllog = "INSERT INTO tblLogs (PersoonID,Log) VALUES ('$persoonid','$username registered as a new user.')";
                $ConnHandigelinksDB -> query($sqllog);
                if (!$ConnHandigelinksDB -> commit()) {
                    echo "Commit transaction failed";
                    exit();
                }

                // Redirect to setting page
                header("location: settings.php");
            } else{
                echo "Oeps! Er is iets mis gegaan. Probeer het later opnieuw. ";
            }

            // Close statement
            $stmt->close();
        }
    }
}

$ConnHandigelinksDB -> close();
header("location:settings.php");
?>