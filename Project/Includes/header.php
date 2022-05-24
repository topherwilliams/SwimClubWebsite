<?php

    require "./Includes/db.php";
    require "./Includes/functions.php";
    require "./Includes/display_errors.php";

    session_start();

    if(!isset($_SESSION['role'])) {
        header("Location: ./login.php");
    }

    $errorMessage = NULL;
    if(isset($_GET['error'])) {
        // Sets error HTML elements when passed through    
        $errorCode = returnCleanUserData($_GET['error']);
        switch($errorCode) {
            case "mandatoryfields":
                $errorMessage = "
                    <div class='error-message'>
                        <p class='error-text' style='margin-top:0px; margin-bottom:0px;'><strong>Unable to update account.</strong></p>
                        <p class='error-text' style='margin-bottom:0px; margin-top:2px;'>The following fields / format rules are mandatory:</p>
                        <ul style='margin-top:0px;'>
                            <li class='error-text' style='font-size:0.9rem;'>User Name (Must be under 20 characters long)</li>
                            <li class='error-text' style='font-size:0.9rem;'>First Name (Must be text)</li>
                            <li class='error-text' style='font-size:0.9rem;'>Surname (Must be text)</li>
                            <li class='error-text' style='font-size:0.9rem;'>Date Of Birth (Must be prior to today)</li>
                            <li class='error-text' style='font-size:0.9rem;'>Email Address (Must be in valid email format)</li>
                            <li class='error-text' style='font-size:0.9rem;'>Address Line 1</li>
                            <li class='error-text' style='font-size:0.9rem;'>Post Code</li>
                            <li class='error-text' style='font-size:0.9rem;'>Account Type</li>
                            <li class='error-text' style='font-size:0.9rem;'>Coach</li>
                        </ul>
                    </div>   
                    ";
                break;
            case "email":
                $errorMessage = "
                    <div class='error-message'>
                        <p class='error-text' style='margin-top:0px; margin-bottom:0px;'><strong>Unable to update email address.</strong></p>
                        <p class='error-text' style='margin-bottom:0px; margin-top:2px;'>An account is already registered to the email address you provided.</p>
                    </div>   
                    ";
                break;
            case "username":
                $errorMessage = "
                    <div class='error-message'>
                        <p class='error-text' style='margin-top:0px; margin-bottom:0px;'><strong>Unable to update user name.</strong></p>
                        <p class='error-text' style='margin-bottom:0px; margin-top:2px;'>An account is already registered with the user name you provided.</p>
                    </div>   
                    ";
                break;
            case "emailandusername":
                $errorMessage = "
                    <div class='error-message'>
                        <p class='error-text' style='margin-top:0px; margin-bottom:0px;'><strong>Unable to update email address and user name.</strong></p>
                        <p class='error-text' style='margin-bottom:0px; margin-top:2px;'>An account is already registered with this user name and email address.</p>
                    </div>   
                    ";
                break;
            case "access":
                $errorMessage = "
                    <div class='error-message'>
                        <p class='error-text' style='margin-top:0px; margin-bottom:0px;'><strong>You don't have access to that part of the site.</strong></p>
                    </div>   
                    ";
                break;
            default:
                $errorMessage = NULL;
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

    <!-- Javascript Load -->
    <script defer src="./js/main.js"></script>


    <title>SUFFOLK SPLASHERS SWIMMING CLUB</title>
</head>
<body>
    <div class="main-container">
        <!-- Main container with background image etc -->
        <div id="title-container" class="container">
            <!-- Title container for site title -->
            <h1 id="page-title">SUFFOLK SPLASHERS SWIMMING CLUB</h1>
        </div>

        <div id="content-container" class="container">    
            <?php
                require "navigation.php"
            ?>

            <div id="main-page-content">