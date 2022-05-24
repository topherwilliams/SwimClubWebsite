<?php

    require "./Includes/db.php";
    require "./Includes/functions.php";
    require "./Includes/display_errors.php";

    $errorMessage = NULL;

    if(isset($_POST['resetPassword'])) {
        $pass1 = returnCleanUserData($_POST['password']);
        $pass2 = returnCleanUserData($_POST['password2']);
        $id  = returnCleanUserData($_POST['userID']);
        if ($pass1 === $pass2) {
            // Set hashed password and salt
            $hashedPassword = password_hash($pass1, PASSWORD_BCRYPT);
            $sqlstatement = " UPDATE users SET password = '{$hashedPassword}', account_locked = '0' WHERE UUID = '{$id}' ";
            $query = mysqli_query($connection, $sqlstatement);
            if (!$query) {
                die("Query failed ". mysqli_error($connection));        
            } else {
                header("Location: index.php");
            }
        } else {
            header("Location: passwordReset.php?id={$id}&error=unmatched");
        }
    }

    if(isset($_GET['error'])) {
        if (returnCleanUserData($_GET['error']) == "unmatched") {
            $errorMessage = "
                <div class='error-message'>
                    <p class='error-text' style='margin-top:0px; margin-bottom:0px;'>Please make sure the 2 passwords match.</p>
                </div>   
            ";
        }
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/c18df075a8.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./css/styles.css">
    <title>SUFFOLK SPLASHERS SWIMMING CLUB</title>
</head>
<body>
    <div class="main-container">
        <!-- Main container with background image etc -->
        <div id="title-container" class="container">
            <!-- Title container for site title -->
            <h1 id="page-title">SUFFOLK SPLASHERS SWIMMING CLUB</h1>
        </div>
        
        <div id="login-container">

            <div id="" class="content-container-login">
                
                <h1>RESET PASSWORD</h1>
                    <?php
                        if($errorMessage) {
                            echo $errorMessage;
                        }
                    ?>
                <form action="passwordReset.php" method="post">
                    <div class="reset-form">
                        
                        <?php
                            // Get ID for use in form
                            if(isset($_GET['id'])) {
                                $id = returnCleanUserData($_GET['id']);
                                
                                echo "
                                    <input hidden type='text' name='userID' value='{$id}'>        
                                ";

                            }
                        ?>
                        <div class="login-group">
                            <div class="login-label">
                                <h3>Password</h3>
                            </div>    
                            <div class="login-data">
                                <input type="text" name="password" class="login-controls">
                            </div>    
                        </div>
                        <div class="login-group">
                            <div class="login-label">
                                <h3>Re-Enter Password</h3>
                            </div>    
                            <div class="login-data">
                                <input type="text" name="password2" class="login-controls">
                            </div>    
                        </div>

                        <div>
                            <button class="colourButton" style="width: 400px; margin-top:30px; margin-bottom:10px;" name="resetPassword">Reset Password...</button>   
                        </div>                        
                    </div>                                       
                </form>
                

<?php 
    // Import Footer
    require "./Includes/footer.php"
?>