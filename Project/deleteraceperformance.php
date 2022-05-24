<?php
    
    // Deletes race performance data and returns to appropriate place in journey
    
    require "./Includes/db.php";
    require "./Includes/functions.php";

    
    // Initial access control to this page - swimmers / parents never have access to the page so redirect them
    if ($_SESSION['role'] == "Swimmer" || $_SESSION['role'] == "Parent" ) {
        header("Location: profile.php?error=access");
    }
    

    if(isset($_GET['raceid'])) {
        $racePerformanceToDelete = returnCleanUserData($_GET['raceid']);
        $query = " DELETE FROM race_performance WHERE race_performance_id = '{$racePerformanceToDelete}'";
        $delete_query = mysqli_query($connection, $query);
        if (!$delete_query) {
            die ("Unable to delete record. " . sqli_error($connection));
        } 
        $id = returnCleanUserData($_GET['userid']);
        header("Location: ./edituser.php?id={$id}");
    }

?>