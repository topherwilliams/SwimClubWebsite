

<div id="side-nav" class="side-nav">
    <div id="sidebar-options">
        <a href="profile.php"><i class="fas fa-user-alt side-bar-icon"></i>My Profile</a>
        <?php
            if(isset($_SESSION['role']) && $_SESSION['role'] == "Coach" ) {
                echo "
                    <a href='manageteam.php'><i class='fas fa-users side-bar-icon'></i>My Team</a>
                ";
            }
        ?>
        <a href="searchraces.php?pagesource=general"><i class="fas fa-swimmer side-bar-icon"></i>All Race Results</a>
        <a href="swimperformance.php"><i class="fas fa-chart-line side-bar-icon"></i>Performance</a>
        <?php
            if(isset($_SESSION['role']) && $_SESSION['role'] == "Club Official" ) {
                echo "
                    <a href='siteadmin.php'><i class='fas fa-users-cog side-bar-icon'></i>Site Admin</a>            
                ";
            }
        ?>
        


    </div>
    <div>
        <a href="logout.php"><i class="fas fa-sign-out-alt side-bar-icon"></i>Sign Out</a>
    </div>
    
</div>