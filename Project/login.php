<?php

    require "./Includes/db.php";
    require "./Includes/functions.php";
    require "./Includes/display_errors.php";

    session_start();
    
    $errorMessage = NULL;

    if(isset($_POST['loginButton'])) {
        $email = returnCleanUserData($_POST['userName']);
        $pass = returnCleanUserData($_POST['password']);

        $sqlstatement = "SELECT * FROM users WHERE email_address = '{$email}'";
        $query = mysqli_query($connection, $sqlstatement);
        if (!$query) {
            die("Query failed ". mysqli_error($connection));        
        } else {
            if (mysqli_num_rows($query) < 1) {
                $errorMessage = "
                    <div class='error-message'>
                        <p class='error-text'>No matching account found. Please check the credentials you have entered or contact the club.</p>
                    </div>   
                ";
            } else {
                $output = mysqli_fetch_assoc($query);
                if ($output['account_locked'] == 1 ) {
                    // Account is locked - don't allow further
                    $errorMessage = "
                        <div class='error-message'>
                            <p class='error-text'>Your account is currently locked. Please reset your password or contact the club</p>
                        </div>   
                    ";
                } else {
                    // Account is found AND isn't locked - check password
                    if(password_verify($pass, $output['password'])) {
                        //Password is correct, set session and redirect
                        $birthday = $output['date_of_birth'];
                        $currentDate = date("Y-m-d");
                        $age = date_diff(date_create($birthday), date_create($currentDate)) ->format("%y");

                        $_SESSION['id'] = $output['UUID'];
                        $_SESSION['username'] = $output['user_name'];
                        $_SESSION['firstname'] = $output['first_name'];
                        $_SESSION['lastname'] = $output['surname'];
                        $_SESSION['age'] = $age;
                        $_SESSION['role'] = $output['role'];   
                        $_SESSION['parent_id'] = $output['parent_id']; 
                        
                        header("Location: index.php");
                    } else {
                        // Password is incorrect
                        // TO-DO: Refer to Visio file - should site track this and lock account after x attempts
                        $errorMessage = "
                            <div class='error-message'>
                                <p class='error-text'>Password is incorrect. Please reset your password of contact the club.</p>
                            </div>   
                        ";
                    }
                }
            }      
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

    <!-- Bootstrap -->
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous"> -->
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
                
                <h1>LOGIN</h1>

                <form action="login.php" method="post">
                <?php
                    if($errorMessage) {
                        echo $errorMessage;
                    }
                ?>    
                    <div class="login-form">
                        <div class="login-group">
                            <div class="login-label">
                                <h3>Email Address</h3>
                            </div>    
                            <div class="login-data">
                                <input type="text" name="userName" class="login-controls">
                            </div>    
                        </div>
                        <div class="login-group">
                            <div class="login-label">
                                <h3>Password</h3>
                            </div>    
                            <div class="login-data">
                                <input type="password" name="password" class="login-controls">
                            </div>    
                        </div>
                        <div>
                            <button class="colourButton" style="width: 400px; margin-top:30px; margin-bottom:10px;" name="loginButton">Login to site...</button>   
                            <p>Forgot your password? <a href="#" class="text-link">click here</a></p>
                        </div>                        
                    </div>                                       
                </form>
                






<?php 
    // Import Footer
    require "./Includes/footer.php"
?>