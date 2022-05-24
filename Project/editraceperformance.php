<?php 
    require "./Includes/header.php";

    
    if(isset($_SESSION['role'])) {
        // Initial access control to this page - swimmers / parents never have access to the page so redirect them
        if ($_SESSION['role'] == "Swimmer" || $_SESSION['role'] == "Parent" ) {
            header("Location: profile.php?error=access");
        }
    }

    if(isset($_POST['editRacePerformanceData'])) {       
        $raceperformancedataID = returnCleanUserData($_POST['editraceperformanceID']);
        $performance = $_POST['racePerformance'];
        $distance = $_POST['race_distance'];
        $metres_per_second = number_format($distance / $performance, 2);
        
        $updatePerformanceSQL = "UPDATE race_performance SET performance = '{$performance}', metres_per_second = '{$metres_per_second}' WHERE race_performance_id = '{$raceperformancedataID}'";
        $updateQuery = mysqli_query($connection, $updatePerformanceSQL);
        if (!$updateQuery) {
            die("Query failed ". mysqli_error($connection));        
        } 
        $userID = returnCleanUserData($_POST['userID']);
        header("Location: ./edituser.php?id={$userID}");
        
    }

    if(isset($_POST['addRacePerformanceData'])) {
        $userID = returnCleanUserData($_POST['userID']);
        $raceID = returnCleanUserData($_POST['raceID']);
        $performance = $_POST['racePerformance'];
        $distance = $_POST['race_distance'];
        $metres_per_second = number_format($distance / $performance, 2);

        $addPerformanceSQL = "INSERT INTO race_performance ( swimmer_id, race_id, performance, metres_per_second ) VALUES ( '{$userID}', '{$raceID}', '{$performance}', '{$metres_per_second}' )";
        $addQuery = mysqli_query($connection, $addPerformanceSQL);
        if (!$addQuery) {
            die("Query failed ". mysqli_error($connection));        
        } 
        header("Location: ./edituser.php?id={$userID}");
    }



    if (isset($_GET['raceid'])) {
        $raceID = returnCleanUserData($_GET['raceid']);
        $userID = returnCleanUserData($_GET['userid']);
        // Check to see if we're adding data for race fresh or editing existing
        $checkRaceSQL = "SELECT * FROM race_performance WHERE race_id = '{$raceID}' AND swimmer_ID = '{$userID}'";
        $checkQuery = mysqli_query($connection, $checkRaceSQL);

        if (!$checkQuery) {
            die("Query failed ". mysqli_error($connection));        
        } else {
            if (mysqli_num_rows($checkQuery) < 1) {
                // No data - adding
                $action = "add";
            } else {
                // Editing data
                $action = "edit";
                $raceperformancerow = mysqli_fetch_assoc($checkQuery);
            }

            $racedetailsSQL = "SELECT * FROM races where race_id = '{$raceID}'";
            $racedetailsQuery = mysqli_query($connection, $racedetailsSQL);
            if (!$racedetailsQuery) {
                die("Query failed ". mysqli_error($connection));        
            } else {
                $raceDetailsRow = mysqli_fetch_assoc($racedetailsQuery);
            }

        }
    } else {
        // header("Location: viewusers.php");
    }
     
  
?>


<div class="content-header">
    <h1><a href="./searchraceperformance.php?id=<?php echo $userID ?>"><i class="fas fa-arrow-left header-navigation-icon"></i></a><?php if($action == "add") {echo "ADD ";} else {echo "EDIT ";}  ?>RACE PERFORMANCE DATA</h1>
</div>

<div class="content-maincontent">
    <form action="editraceperformance.php" method="post">
        <input type="text" hidden name="userID" value='<?php echo $userID ?>'>
        <input type="text" hidden name="raceID" value='<?php echo $raceID ?>'>
        <input hidden type='text' name='race_distance' value='<?php echo $raceDetailsRow['race_length'] ?>'>
           
        <?php 
            // Import user fields
            require "./Includes/race_performance_fields.php"
        ?>

          
        <div class="profile-group">

            <div class="profile-button">
                <?php

                    if ($action == "add") {
                        echo "
                            <button class='colourButton' name='addRacePerformanceData'>Add Race Performance Data</button>        
                        ";
                    } else {
                        echo "
                            <button class='colourButton' name='editRacePerformanceData'>Edit Race Performance Data</button>        
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