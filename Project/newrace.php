<?php 
    require "./Includes/header.php";
    if(isset($_SESSION['role']) && $_SESSION['role'] != "Club Official") {
        header("Location: profile.php?error=access");
    }

    // TO DO: Add validation in here once login / sessions are built so that adding user can only be done by users with club official roles

    if(isset($_POST['createRace'])) {
        // TO DO: ADD VALIDATION SO THAT EMPTY FORMS CAN'T BE PROCESSED
        $raceName = titleCase(returnCleanUserData($_POST['raceName']));
        $raceTown = titleCase(returnCleanUserData($_POST['raceTown']));
        $racePool = titleCase(returnCleanUserData($_POST['racePool']));
        $raceLength = returnCleanUserData($_POST['raceLength']);
        $raceDate = returnCleanUserData($_POST['dateOfRace']);
        
        $sqlstatement = "INSERT INTO races ( race_name, race_town, race_pool, race_length, race_date) VALUES ('{$raceName}', '{$raceTown}', '{$racePool}', '{$raceLength}', '{$raceDate}' )";
        
        $query = mysqli_query($connection, $sqlstatement);
        if (!$query) {
            die("Query failed ". mysqli_error($connection));        
        } else {
            // Record has been saved to database. Redirect user to the main admin page
                header("Location: siteadmin.php");
        }
    }
  
?>


<div class="content-header">
    <h1><a href="./siteadmin.php"><i class="fas fa-arrow-left header-navigation-icon"></i></a>CREATE NEW RACE</h1>
</div>

<div class="content-maincontent">
    <form id="createRaceForm" action="newrace.php" method="post">

           
        <?php 
            // Import user fields
            require "./Includes/race_fields.php"
        ?>

          
        <div class="profile-group">

            <div class="profile-button">
                <button class='colourButton' name='createRace'>Create Race Event</button>
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