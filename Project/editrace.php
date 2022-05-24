<?php 
    require "./Includes/header.php";
    
    if(isset($_SESSION['role']) && $_SESSION['role'] != "Club Official") {
        header("Location: profile.php?error=access");
    }

    // Add validation in here once login / sessions are built so that adding user can only be done by users with club official roles

    if(isset($_POST['editRace'])) {
        $raceID = returnCleanUserData($_POST['id']);
        $raceName = titleCase(returnCleanUserData($_POST['raceName']));
        $raceTown = titleCase(returnCleanUserData($_POST['raceTown']));
        $racePool = titleCase(returnCleanUserData($_POST['racePool']));
        $raceLength = returnCleanUserData($_POST['raceLength']);
        $raceDate = returnCleanUserData($_POST['dateOfRace']);
        
        $sqlstatement = " UPDATE races SET race_name = '{$raceName}', race_town = '{$raceTown}', race_pool = '{$racePool}', race_length = '{$raceLength}', race_date = '{$raceDate}' WHERE race_id = '{$raceID}' ";
        
        $query = mysqli_query($connection, $sqlstatement);
        if (!$query) {
            die("Query failed ". mysqli_error($connection));        
        } else {
            header("Location: searchraces.php?pagesource=admin&id={$raceID}");
        }
    }


    if (isset($_GET['id'])) {
        $id = returnCleanUserData($_GET['id']);
        $sqlstatement = "SELECT * FROM races WHERE race_id = '{$id}'";
        $query = mysqli_query($connection, $sqlstatement);
        if(!$query) {
            die("Query failed ". mysqli_error($connection));        
        } else {
            $row = mysqli_fetch_assoc($query);
        }
    }


?>


<div class="content-header">
    <h1><a href="./searchraces.php?pagesource=admin&id=<?php echo $row['race_id'] ?>"><i class="fas fa-arrow-left header-navigation-icon"></i></a>EDIT RACE</h1>
</div>

<div class="content-maincontent">
    <form id="editRaceForm" action="editrace.php" method="post">
        <input hidden name="id" value="<?php echo $row['race_id']?>">

        <?php 
            // Import user fields
            require "./Includes/race_fields.php"
        ?>

        
    
        <div class="profile-group">
            <div class="profile-button">
                <button class="colourButton" name="editRace">Save Changes</button>
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