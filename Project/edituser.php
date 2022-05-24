<?php 
    require "./Includes/header.php";
    

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
                        if($pagesource == "myprofile") {
                            header("Location: ./profile.php?error=emailandusername");
                        } else {
                            header("Location: ./edituser.php?pagesource={$pagesource}&id={$guid}&error=emailandusername");
                        }
                    } 
                    if ($existingResult['user_name'] == $userName) {
                        //Username is in use 
                        if($pagesource == "myprofile") {
                            header("Location: ./profile.php?error=username");
                        } else {
                            header("Location: ./edituser.php?pagesource={$pagesource}&id={$guid}&error=username");
                        }
                    } 
                    if ($existingResult['email_address'] == $emailAddress) {
                        //Email address is in use
                        if($pagesource == "myprofile") {
                            header("Location: ./profile.php?error=email");
                        } else {
                            header("Location: ./edituser.php?pagesource={$pagesource}&id={$guid}&error=email");
                        }
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
                if($pagesource == "myteam") {
                    header("Location: ./manageteam.php");    
                } else if ($pagesource == "myprofile") {
                    header("Location: ./profile.php");    
                } else if ($pagesource == "viewusers") {
                    header("Location: ./viewusers.php?searchID={$guid}");
                }
            }
        } else {
            // Not all mandatory information provided
            if($pagesource == "myteam") {
                header("Location: ./edituser.php?pagesource=myteam&id={$guid}&error=mandatoryfields");    
            } else {
                header("Location: ./edituser.php?pagesource=viewusers&id={$guid}&error=mandatoryfields");
            }
        }
    }


    if(isset($_SESSION['role'])) {
        // Initial access control to this page - swimmers never have access to the page so redirect them
        if ($_SESSION['role'] == "Swimmer") {
            header("Location: profile.php?error=access");
        }
    }

    if(isset($_GET['pagesource'])) {
        $pagesource = returnCleanUserData($_GET['pagesource']);
    }

    if (isset($_GET['id'])) {
        $id = returnCleanUserData($_GET['id']);
        $sqlstatement = "SELECT * FROM users WHERE UUID = '{$id}'";
        $query = mysqli_query($connection, $sqlstatement);
        if(!$query) {
            die("Query failed ". mysqli_error($connection));        
            header("Location: profile.php?error=access");
        } else {
            $row = mysqli_fetch_assoc($query);
            // Secondary access control - if parent / coach tries to access page for unauthorised person
            if($_SESSION['role'] == "Parent" && $row['parent_id'] != $_SESSION['id'] ) {
                // If parent user tries to access edit page for someone who isn't linked to them then redirect
                header("Location: profile.php?error=access");
            }
            if($_SESSION['role'] == "Coach" && $row['coach_id'] != $_SESSION['id'] ) {
                // If coach user tries to access edit page for someone who isn't linked to them then redirect
                header("Location: profile.php?error=access");
            }
        }
    }


?>


<div class="content-header">
    <?php
        // Making sure that the back button behaviour takes back to the correct place
        if(isset($pagesource) && $pagesource =="myteam" || $_SESSION['role'] == "Coach") {
            echo "
                <h1><a href='./manageteam.php'><i class='fas fa-arrow-left header-navigation-icon'></i></a>EDIT ACCOUNT</h1>        
            ";
        } else if ($_SESSION['role'] == "Parent"){
            echo "
                <h1><a href='./profile.php'><i class='fas fa-arrow-left header-navigation-icon'></i></a>EDIT ACCOUNT</h1>        
            ";
        } else {
            echo "
                <h1><a href='./viewusers.php?searchID={$row['UUID']}'><i class='fas fa-arrow-left header-navigation-icon'></i></a>EDIT ACCOUNT</h1>        
            ";
        }
    ?>
    
</div>


<div class="content-maincontent">
    <?php
        if($errorMessage) {
            echo $errorMessage;
        }
    ?>
    <form id="editUserForm" action="edituser.php" method="post">
        <input hidden name="id" value="<?php echo $row['UUID']?>">
        <input hidden name="currentEmailAddress" value="<?php echo $row['email_address']?>">
        <input hidden name="currentUserName" value="<?php echo $row['user_name']?>">
        <input hidden name="pagesource" value="<?php echo $pagesource ?>">

        <?php 
            // Import user fields
            require "./Includes/user_fields.php"
        ?> 
    
        <div class="profile-group">
            <div class="profile-button">
                <button class="colourButton" name="editAccount">Save Changes</button>
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