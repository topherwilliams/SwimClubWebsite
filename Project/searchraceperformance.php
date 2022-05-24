<?php 
    require "./Includes/header.php";

    if(isset($_SESSION['role'])) {
        // Initial access control to this page - swimmers / parents never have access to the page so redirect them
        if ($_SESSION['role'] == "Swimmer" || $_SESSION['role'] == "Parent" ) {
            header("Location: profile.php?error=access");
        }
    }


    // Add validation in here once login / sessions are built so that only club official roles can view all members
    
    $id = "";

    if(isset($_POST['submitperformanceData'])) {
        // Performance data added to a race.
        $performance = returnCleanUserData($_POST['performanceTime']);
        if($performance != NULL) {
            $raceID = returnCleanUserData($_POST['raceID']);
            $userID = returnCleanUserData($_POST['userID']);
            $newRaceDataSQL = "INSERT INTO race_performance ( swimmer_id, race_id, Performance) VALUES ('{$userID}', '{$raceID}', '{$performance}' ) ";
            $newRaceDataQuery = mysqli_query($connection, $newRaceDataSQL);
            if(!$newRaceDataQuery) {
                die("Query failed ". mysqli_error($connection));       
            } else {
                header("Location: ./edituser.php?id={$userID}");
            }
        }
    }



    if(isset($_POST['searchRaces'])) {
        $validSearch = false;
        // Assemble SQL Query Dynamically
        $raceTown = titleCase(returnCleanUserData($_POST['race_town']));
        $raceLength = returnCleanUserData($_POST['race_length']);
        $raceStartDate = returnCleanUserData($_POST['race_dateStart']);
        $raceEndDate = returnCleanUserData($_POST['race_dateEnd']);
        $id = returnCleanUserData($_POST['userID']);
       
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
            $sqlstatement = "SELECT * FROM races WHERE {$whereStr} ORDER BY race_date ASC";
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
    }

    if(isset($_GET['id'])) {
        //Reference passed back from editing a user so show that user in search
        //$validSearch = true;
        $id = returnCleanUserData($_GET['id']);
    }

    if(!isset($_GET['id']) && !isset($_POST['searchRaces'])) {
        header("Location: viewusers.php");
    }
    
?>


<div class="content-header">
    <h1><a href="./edituser.php<?php if($id) {echo '?id=' . $id; } ?>"><i class="fas fa-arrow-left header-navigation-icon"></i></a>SEARCH FOR RACE</h1>
</div>

<div class="content-maincontent">
    
    <!-- Form to search for users -->
    <form action="searchraceperformance.php" method="post">
        <input hidden type="text" name="userID" value="<?php echo $id ?>"> 
        <?php
                include "./includes/race_search_box.php"
            ?>
    </form>

    <!-- Search Results -->
    <div id='searchResults'>
        <table class='user-table'>
            <thead>
                <th>Race Name</th>
                <th>Town</th>
                <th>Pool</th>
                <th>Race Length(m)</th>
                <th>Race Date</th>
                <th class='table-icons'>Add Performance Data</th>
            </thead>                            
            <tbody>
                <?php
                    
                    if($validSearch == false) {
                        echo "
                            <tr><td><h3 class='error_text' >No Search Results Found.</h3></td></tr>
                        ";
                    } else {
                        while ($rows = mysqli_fetch_assoc($query)) {              
                            $adjustedDate = date("d/m/Y", strtotime($rows['race_date']));
                            echo "
                                
                                <tr>
                                    <td>{$rows['race_name']}</td>
                                    <td>{$rows['race_town']}</td>
                                    <td>{$rows['race_pool']}</td>
                                    <td>{$rows['race_length']}</td>
                                    <td>{$adjustedDate}</td>
                                    <td class='table-icons'><a class='user-icons' href='./editraceperformance.php?raceid={$rows['race_id']}&userid={$id}'><i class='fas fa-plus'></i></a></td>
                                </tr>        
                                
                                
                            ";
                        }
                    }
                ?>
                
            </tbody>                                    
        </table>
    </div>    

</div>

<div class="content-footer">
</div>



<?php 
    // Import Footer
    require "./Includes/footer.php"
?>