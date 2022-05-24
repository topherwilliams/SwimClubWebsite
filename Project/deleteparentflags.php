<?php
    
    // Removes parent_id from accounts when child reaches 18 years old so that they can edit their own data and parent no longer has access.
    
    require "./Includes/db.php";
    require "./Includes/functions.php";
    
    $dateMinus18Years = date('Y-m-d', strtotime('-18 year'));
    $updateParentFlagSQL = "UPDATE users SET parent_id = 'NULL' WHERE date_of_birth <= '{$dateMinus18Years}' AND parent_id != 'NULL' ";
    $updateQuery = mysqli_query($connection, $updateParentFlagSQL);
    if(!$updateQuery) {
        die("Query failed ". mysqli_error($connection));        
    }
    header("Location: siteadmin.php");

?>