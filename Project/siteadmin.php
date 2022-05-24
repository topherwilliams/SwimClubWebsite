<?php 
    // This file is the main window content for the site, from where all functions are accessible.
    
    // DB Functions / session import here 

    require "./Includes/header.php";
    if(isset($_SESSION['role']) && $_SESSION['role'] != "Club Official") {
        header("Location: profile.php?error=access");
    }
?>


<div class="content-header">
    <h1>SITE ADMIN</h1>
</div>    

<div id="admin-choices" style="display:flex;">
    <div id="user-admin" style="width:50%; margin-left:20px;">
        <h2>Users</h2>
        <p><a class="text-link" href="newuser.php">Create New User</a></p>
        <p><a class="text-link" href="viewusers.php">Search / Edit Users</a></p>
        <p style="margin-top:30px;"><a class="text-link" href="deleteparentflags.php">Remove Parent Flags (Daily Task)</a></p>
    </div>
    <div id="race-admin">
        <h2>Races</h2>
        <p><a class="text-link" href="newrace.php">Create New Race Event</a></p>
        <p><a class="text-link" href="searchraces.php?pagesource=admin">Search / Edit Races</a></p>
    </div>


</div>



<?php 
    // Import Footer
    require "./Includes/footer.php"
?>