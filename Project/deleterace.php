<?php
    
    // Deletes account and returns to appropriate place in journey
    // If deleting a linked account from a parent edit page, record is deleted and user is returned to the parents edit page again
    // If deleting from the view all page, record is deleted and user is sent back to the view user page.
    
    require "./Includes/db.php";
    require "./Includes/functions.php";

    if($_SESSION['role'] == "Club Official") {
        if(isset($_GET['id'])) {
            $raceToDelete = returnCleanUserData($_GET['id']);
            $query = " DELETE FROM races WHERE race_id = '{$raceToDelete}'";
            $delete_query = mysqli_query($connection, $query);
            if (!$delete_query) {
                die ("Unable to delete record. " . sqli_error($connection));
            } else {    
                header("Location: searchraces.php?pagesource=admin");
            }
        } else {
            header("Location: searchraces.php?pagesource=admin");
        }   
    } else {
        header("Location: profile.php?error=access");
    }

    

?>