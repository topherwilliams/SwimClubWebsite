<?php 
    // This file is the main window content for the site, from where all functions are accessible.
    
    // DB Functions / session import here 

    require "./Includes/header.php";
    $page = "profile";


    if(isset($_POST['editAccount'])) {
        
        // Check amended email address / user name to see if account can be updated
        $userName = returnCleanUserData($_POST['userName']);
        $emailAddress = strtolower(returnCleanUserData($_POST['emailAddress']));
        $pagesource = returnCleanUserData($_POST['pagesource']);
        $currentUserName = returnCleanUserData($_POST['currentUserName']);
        $currentEmailAddress = returnCleanUserData($_POST['currentEmailAddress']);
        $guid = returnCleanUserData($_POST['id']);

        if($username != $currentUserName || $emailAddress != $currentEmailAddress) {
            // Trying to change user name or password - need to make sure that the new email address / user name isn't already in use.
             
            $checkEmailSQL = "SELECT id, user_name, email_address FROM users WHERE email_address = '{$emailAddress}' OR user_name = '{$userName}'";
            $checkEmailQuery = mysqli_query($connection, $checkEmailSQL);
            if (!$checkEmailQuery) {
                die("Query failed ". mysqli_error($connection));        
            } else {
                if(mysqli_num_rows($checkEmailQuery) > 0) {
                    // Other accounts with the new user name / password - redirect to display error message
                    $existingResult = mysqli_fetch_assoc($checkEmailQuery);
                    if ($existingResult['user_name'] == $userName && $existingResult['email_address'] == $emailAddress) {
                        //Both username and email address are in use
                        header("Location: ./profile.php?error=emailandusername");
                    } 
                    if ($existingResult['user_name'] == $userName) {
                        //Username is in use 
                        header("Location: ./profile.php?error=username");
                    } 
                    if ($existingResult['email_address'] == $emailAddress) {
                        //Email address is in use
                        header("Location: ./profile.php?error=email");
                    } 
                }
            }
        }

        // If okay to proceed - ie no changes to email / user name or new username / email are okay to use then proceed
        $firstName = titleCase(returnCleanUserData($_POST['firstName']));
        $lastName = titleCase(returnCleanUserData($_POST['lastName']));
        $dateOfBirth = returnCleanUserData($_POST['dateOfBirth']);        
        $phoneNumber = returnCleanUserData($_POST['phoneNumber']);
        $addressLine1 = titleCase(returnCleanUserData($_POST['addressLine1']));
        $addressLine2 = titleCase(returnCleanUserData($_POST['addressLine2']));
        $town = titleCase(returnCleanUserData($_POST['town']));
        $city = titleCase(returnCleanUserData($_POST['city']));
        $county = titleCase(returnCleanUserData($_POST['county']));
        $postCode = strtoupper(returnCleanUserData($_POST['postCode']));
        $accountSelection = returnCleanUserData($_POST['accountSelection']);
        $coach = returnCleanUserData($_POST['coachSelection']);
        
        if ( $userName && strlen($userName) <= 20 &&  $firstName && is_string($firstName) && $lastName && is_string($lastName) && isValidDateOfBirth($dateOfBirth) && isValidEmailAddress($emailAddress) && $addressLine1 && $postCode && $accountSelection != "None" && $coach != "None" ) {
            // All mandatory fields provided - proceed to insert into database
        
            $sqlstatement = " UPDATE users SET user_name = '{$userName}', first_name = '{$firstName}', surname = '{$lastName}', date_of_birth = '{$dateOfBirth}', email_address = '{$emailAddress}', telephone_number = '{$phoneNumber}', address_line_1 = '{$addressLine1}', address_line_2 = '{$addressLine2}', town = '{$town}', city = '{$city}', county = '{$county}', post_code = '{$postCode}', role = '{$accountSelection}', coach_id = '{$coach}' WHERE UUID = '{$guid}' ";
        
            $query = mysqli_query($connection, $sqlstatement);
            if (!$query) {
                die("Query failed ". mysqli_error($connection));        
            } else {
                // Successful update of record - Make sure that user is directed to the appropriate place once change has been made - manage team goes back to that page etc
                header("Location: ./profile.php");    
            }
        } else {
            // Not all mandatory information provided
            header("Location: ./profile.php?error=mandatoryfields");    
        }
    }

    if (isset($_SESSION['id'])) {
        // Valid person signed in
        $id = returnCleanUserData($_SESSION['id']);
        $sqlstatement = "SELECT * FROM users WHERE UUID = '{$id}'";
        $query = mysqli_query($connection, $sqlstatement);
        if(!$query) {
            die("Query failed ". mysqli_error($connection));        
        } else {
            $row = mysqli_fetch_assoc($query);
        }
    } 

    // Error Handling
?>


<div class="content-header">
    <h1>MY PROFILE</h1>
</div>

<div class="content-maincontent">

    <?php
        if($errorMessage) {
            echo $errorMessage;
        }
    ?>

    <form action="profile.php" method="post">
        <input hidden name="pagesource" value="myprofile">
        <input hidden name="id" value="<?php echo $row['UUID'] ?>">
        <input hidden name="currentEmailAddress" value="<?php echo $row['email_address']?>">
        <input hidden name="currentUserName" value="<?php echo $row['user_name']?>">
        <?php 
            // Import user fields
            require "./Includes/user_fields.php"
        ?>

        <!-- Unique submit button required here -->
        <div class="profile-group">
            <div class="profile-button">
                <?php
                    if (isset($_SESSION['role']) && !isset($_SESSION['parent_id'])) {
                        echo "
                            <button class='colourButton' name='editAccount'>Save Changes</button>
                        ";
                    }

                ?>
                
            </div>    
        </div>

    </form>



</div>




<div class="content-footer">


</div>


<?php 
    // Import Footer
    require "./Includes/footer.php"
?>