<?php 
    require "./Includes/header.php";

    // Add validation in here once login / sessions are built so that only club official roles can view all members

    if(isset($_POST['searchRaces'])) {
        $validSearch = false;
        // Assemble SQL Query Dynamically
        $raceTown = titleCase(returnCleanUserData($_POST['race_town']));
        $raceLength = returnCleanUserData($_POST['race_length']);
        $raceStartDate = returnCleanUserData($_POST['race_dateStart']);
        $raceEndDate = returnCleanUserData($_POST['race_dateEnd']);
        $pagesource = returnCleanUserData($_POST['pagesource']);
        
        if ($pagesource == "admin") {
            $tableType = "adminTable";
        } else {
            $tableType = "generalTable";
        }

        if ($raceTown || $raceLength || $raceStartDate && $raceEndDate) {
            // Only do search if values entered in one or more search fields
            $validSearch = true;
            $whereArr = array();
            if($raceTown) {
                $whereArr[] = "race_town LIKE '{$raceTown}' OR race_pool LIKE '{$raceTown}'";
            }
            if($raceLength) {
                $whereArr[] = "race_length LIKE '{$raceLength}'";
            }
            if($raceStartDate && $raceEndDate) {
                if($raceStartDate <= $raceEndDate) {
                    $whereArr[] = "race_date BETWEEN '{$raceStartDate}' and '{$raceEndDate}'";
                }
            }
            $whereStr = implode(" AND ", $whereArr);
            $sqlstatement = "SELECT * FROM races WHERE {$whereStr} ORDER BY race_date DESC";
            $query = mysqli_query($connection, $sqlstatement);
            if(!$query) {
                die("Query failed ". mysqli_error($connection));       
            } else {
                if(mysqli_num_rows($query) < 1 ) {
                    $validSearch = false;            
                }
            }           
        }
    } else {
        $validSearch = false;
        if(isset($_GET['id'])) {
            //Reference passed back from editing a user so show that user in search
            $validSearch = true;
            $id = returnCleanUserData($_GET['id']);
            $sqlstatement = "SELECT * FROM races WHERE race_id = '{$id}'";
            $query = mysqli_query($connection, $sqlstatement);
            if(!$query) {
                die("Query failed ". mysqli_error($connection));       
            } 
        }
    
        if (isset($_GET['pagesource'])) {
            $pagesource = returnCleanUserData($_GET['pagesource']);
            if ($pagesource == "admin") {
                $tableType = "adminTable";
            } else {
                $tableType = "generalTable";
            }
        } else {
            $tableType = "generalTable";
        }
    }

    
?>


<div class="content-header">
    
    <?php
        if ($tableType == "adminTable") {
            echo "
                <h1><a href='./siteadmin.php'><i class='fas fa-arrow-left header-navigation-icon'></i></a>SEARCH / EDIT RACES</h1>
            ";
        } else {
            echo "
                <h1>SEARCH RACES</h1>
            ";
        }
    ?>
        
</div>

<div class="content-maincontent">
    
    <!-- Form to search for users -->
    <form action="searchraces.php" method="post">
            <input hidden name="pagesource" value="<?php echo $pagesource ?>" type="text">
            <?php
                include "./includes/race_search_box.php"
            ?>
    </form>

    <!-- Search Results -->
    <?php
        include "./includes/race_table.php";

    ?>

</div>

<div class="content-footer">
</div>



<?php 
    // Import Footer
    require "./Includes/footer.php"
?>