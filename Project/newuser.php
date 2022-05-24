<?php 
    require "./Includes/header.php";
    
    if(isset($_SESSION['role']) && $_SESSION['role'] != "Club Official") {
        header("Location: profile.php?error=access");
    }

    if(isset($_POST['createAccount'])) {
        
        $emailAddress = strtolower(returnCleanUserData($_POST['emailAddress']));
        $userName = returnCleanUserData($_POST['userName']);

        if (isset($_POST['parentId'])) {
            // Check to make sure whether creating a normal or linked (i.e. child) account
            $accountToCreate = "Linked";
            $parentID = returnCleanUserData($_POST['parentId']);
            $parentUserName = returnCleanUserData($_POST['parentUserName']);
        } else {
            $accountToCreate = "Normal";
        }       

        // Check Email Address / User Name first as these are unique key for account
        $checkEmailSQL = "SELECT id, user_name, email_address FROM users WHERE email_address = '{$emailAddress}' OR user_name = '{$userName}'";
        $checkEmailQuery = mysqli_query($connection, $checkEmailSQL);
        if (!$checkEmailQuery) {
            die("Query failed ". mysqli_error($connection));        
        } else {
            if (mysqli_num_rows($checkEmailQuery) > 0) {
                // Email address or user name is already registered - redirect to display appropriate error message to user

                $existingResult = mysqli_fetch_assoc($checkEmailQuery);
                if ($existingResult['user_name'] == $userName && $existingResult['email_address'] == $emailAddress) {
                    //Both username and email address are in use
                    if($accountToCreate == "Linked") {
                        header("Location: ./newuser.php?type=linkedAccount&id={$parentID}&parentUserName={$parentUserName}&error=emailandusername");
                    } else {
                        header("Location: ./newuser.php?error=emailandusername");
                    }
                } 
                if ($existingResult['user_name'] == $userName) {
                    //Username is in use 
                    if($accountToCreate == "Linked") {
                        header("Location: ./newuser.php?type=linkedAccount&id={$parentID}&parentUserName={$parentUserName}&error=username");
                    } else {
                        header("Location: ./newuser.php?error=username");
                    }
                } 
                if ($existingResult['email_address'] == $emailAddress) {
                    //Email address is in use
                    if($accountToCreate == "Linked") {
                        header("Location: ./newuser.php?type=linkedAccount&id={$parentID}&parentUserName={$parentUserName}&error=email");
                    } else {
                        header("Location: ./newuser.php?error=email");
                    }
                } 
            } else {
                // No records found with the user name / email address so create new record in DB

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
                $guid = guidv4();

                // Check for all mandatory fields
                if ( $userName && strlen($userName) <= 20 && $firstName && is_string($firstName) && $lastName && is_string($lastName) && isValidDateOfBirth($dateOfBirth) && isValidEmailAddress($emailAddress) && $addressLine1 && $postCode && $accountSelection != "None" && $coach != "None" ) {
                    // All mandatory fields provided - proceed to insert into database

                    if($accountToCreate == "Linked") {
                        $sqlstatement = "INSERT INTO users ( user_name, first_name, surname, date_of_birth, email_address, telephone_number, address_line_1, address_line_2, town, city, county, post_code, role, UUID, parent_id, coach_id ) VALUES ('{$userName}', '{$firstName}', '{$lastName}', '{$dateOfBirth}', '{$emailAddress}', '{$phoneNumber}', '{$addressLine1}', '{$addressLine2}', '{$town}', '{$city}', '{$county}', '{$postCode}', '{$accountSelection}', '{$guid}', '{$parentID}', '{$coach}' )";
                    } else {
                        $sqlstatement = "INSERT INTO users ( user_name, first_name, surname, date_of_birth, email_address, telephone_number, address_line_1, address_line_2, town, city, county, post_code, role, UUID, coach_id ) VALUES ( '{$userName}', '{$firstName}', '{$lastName}', '{$dateOfBirth}', '{$emailAddress}', '{$phoneNumber}', '{$addressLine1}', '{$addressLine2}', '{$town}', '{$city}', '{$county}', '{$postCode}', '{$accountSelection}', '{$guid}', '{$coach}' )";      
                    }

                    $query = mysqli_query($connection, $sqlstatement);
                    if (!$query) {
                        die("Query failed ". mysqli_error($connection));        
                    } else {
                        if($accountToCreate == "Linked") {
                            // Redirect to view the parent profile.
                            header("Location: edituser.php?id={$parentID}");
                        } else {
                            // Redirect to view the new user profile.
                            header("Location: edituser.php?id={$guid}");
                        }
                    }
                } else {
                    // Mandatory fields not provided or not in the right format - redirect and display error message
                    if($accountToCreate == "Linked") {
                        header("Location: ./newuser.php?type=linkedAccount&id={$parentID}&parentUserName={$parentUserName}&error=mandatoryfields");
                    } else {
                        header("Location: ./newuser.php?error=mandatoryfields");
                    }
                }
            }
        }
    }

?>


<div class="content-header">
    <h1><a href="./siteadmin.php"><i class="fas fa-arrow-left header-navigation-icon"></i></a>CREATE NEW ACCOUNT</h1>
</div>

<div class="content-maincontent">
    
    <?php
        if($errorMessage) {
            //If error message code sent with page request then display resulting error message
            echo $errorMessage;
        }
    ?>

    <form id="createUserForm" action="newuser.php" method="post">
        <?php
            if(isset($_GET['type']) && returnCleanUserData($_GET['type']) == "linkedAccount") {
                $parentID = returnCleanUserData($_GET['id']);
                $parentUserName = returnCleanUserData($_GET['parentUserName']);
                echo "
                    <input hidden type='text' name='parentId' value='{$parentID}'>            
                    <div class='profile-group'>
                        <div class='profile-label'>
                            <h3>Parent's User Name</h3>
                        </div>    
                        <div class='profile-data'>
                            <input readonly type='text' name='parentUserName' value='{$parentUserName}' class='input-controls'>
                        </div>    
                    </div>
                ";                
            }
 
            // Import user fields
            require "./Includes/user_fields.php"
        ?>

          
        <div class="profile-group">

            <div class="profile-button">
                <?php
                    if(isset($_GET['type']) && returnCleanUserData($_GET['type']) == "linkedAccount") {
                        echo "
                            <button class='colourButton' name='createAccount'>Create Linked Account</button>
                        ";
                    } else {
                        echo "
                            <button class='colourButton' name='createAccount'>Create Account</button>
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