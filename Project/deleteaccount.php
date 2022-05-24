<?php
    
    // Deletes account and returns to appropriate place in journey
    // If deleting a linked account from a parent edit page, record is deleted and user is returned to the parents edit page again
    // If deleting from the view all page, record is deleted and user is sent back to the view user page.
    
    require "./Includes/db.php";
    require "./Includes/functions.php";

    if($_SESSION['role'] == "Club Official") {
        if(isset($_GET['id'])) {
            $accountToDelete = returnCleanUserData($_GET['id']);
            $source = returnCleanUserData($_GET['source']);
            $query = " DELETE FROM users WHERE UUID = '{$accountToDelete}'";
            $delete_query = mysqli_query($connection, $query);
            if (!$delete_query) {
                die ("Unable to delete record. " . sqli_error($connection));
            } else {
                if ($source == "edit" ) {
                    //Redirect to edit page - i.e for parents
                    $sourceid = returnCleanUserData($_GET['parentID']);
                    header("Location: edituser.php?id={$sourceid}");    
                } elseif ($source == "viewusers") {
                    //Redirect back to view users page
                    header("Location: viewusers.php");
                }
            }
        } else {
            header("Location: viewusers.php");
        }    
    } else {
        header("Location: profile.php?error=access");
    }


    

?>