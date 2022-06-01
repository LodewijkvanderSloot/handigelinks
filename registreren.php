<?php
include "dbconn.php";
include "header.php";
?>
<?php
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Vul een gebruikersnaam in.";
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
                    $username_err = "Deze gebruikersnaam bestaat al.";
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
        $password_err = "Vul een wachtwoord in. ";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Het wachtwoord moet minimaal 6 tekens bevatten. ";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Bevestig het wachtwoord. ";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Wachtwoorden komen niet overeen. ";
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
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Oeps! Er is iets mis gegaan. Probeer het later opnieuw. ";
            }

            // Close statement
            $stmt->close();
        }
    }
    
    // Close connection
    $ConnHandigelinksDB->close();
}
?>
 
    <body>
        <ul class="menu">
            <li class="actief"><a href=registreren.php>Registreren</a></li>
            <li class="menu"><a href="login.php">Aanmelden</a></li>
        </ul>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <table>
            <tr>
                <td><h1>Nieuw gebruikersaccount registreren</h1></td>
            </tr>
        </table>
        <hr>
        <table>
            <tr>
                <td><label for="username">Gebruikersnaam: </label></td>
                <td><input type="text" name="username" value="<?php echo $username; ?>"></td>
                <td><span class="help-block"><?php echo $username_err; ?></span></td>
            </tr>
            <tr>
                <td><label for="password">Wachtwoord: </label></td>
                <td><input type="password" name="password" value="<?php echo $password; ?>"></td>
                <td><span class="help-block"><?php echo $password_err; ?></span></td>
            </tr>
            <tr>
                <td><label for="confirm_password">Bevestig wachtwoord: </label></td>
                <td><input type="password" name="confirm_password" value="<?php echo $confirm_password; ?>"></td>
                <td><span class="help-block"><?php echo $confirm_password_err; ?></span></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:right"><input type="submit"><input type="reset"></td>
                <td></td>
            </tr>
        </table>
        
            <p>Heb je al een gebruikersaccount? <a href="login.php">Log dan hier in</a>.</p>
        </form>  
</body>
</html>
<?php
$ConnHandigelinksDB -> close();
?>