<?php 
    // This file is the main window content for the site, from where all functions are accessible.
    
    // DB Functions / session import here 
    require "./Includes/header.php";

    if(isset($_SESSION['role']) && $_SESSION['role'] != "Coach") {
        header("Location: profile.php?error=access");
    }

    $pageSource = "myteam";

    if(isset($_SESSION['role']) && $_SESSION['role'] == "Coach") {
        $validSearch = true;
        $coachSwimmersSQL = "SELECT * FROM users WHERE coach_id = '{$_SESSION['id']}'";
        $query = mysqli_query($connection, $coachSwimmersSQL);
        if(!$query) {
            die("Query failed ". mysqli_error($connection));        
        } else {
            if(mysqli_num_rows($query) < 1 ) {
                $validSearch = false;            
            } 
        }
    }
?>


<div class="content-header">
    <h1>MY TEAM MEMBERS</h1>
</div>


<?php
    include "./includes/user_table.php"

?>

<?php 
    // Import Footer
    require "./Includes/footer.php"
?>