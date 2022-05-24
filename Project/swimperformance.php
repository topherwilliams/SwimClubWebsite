<?php 
    require "./Includes/header.php";


    // Add validation in here once login / sessions are built so that only club official roles can view all members

    if(isset($_POST['searchRaces'])) {
        $validSearch = false;
        // Assemble SQL Query Dynamically
        $raceLength = returnCleanUserData($_POST['race_length']);
        $raceStartDate = returnCleanUserData($_POST['race_dateStart']);
        $raceEndDate = returnCleanUserData($_POST['race_dateEnd']);
       
        if ($raceLength || $raceStartDate && $raceEndDate) {
            // Only do search if values entered in one or more search fields
            $validSearch = true;
            $whereArr = array();
            if($raceLength) {
                $whereArr[] = "races.race_length LIKE '{$raceLength}'";
            }
            if($raceStartDate && $raceEndDate) {
                if($raceStartDate <= $raceEndDate) {
                    $whereArr[] = "races.race_date BETWEEN '{$raceStartDate}' and '{$raceEndDate}'";
                }
            }
            $whereStr = implode(" AND ", $whereArr);
            
            $sqlstatement = "SELECT * FROM race_performance INNER JOIN races ON race_performance.race_id = races.race_id INNER JOIN users ON race_performance.swimmer_id = users.UUID   WHERE {$whereStr} ORDER BY race_performance.metres_per_second DESC";
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


    
?>


<div class="content-header">
    <h1>SWIMMER DATA</h1>
</div>

<div class="content-maincontent">
    
    <!-- Form to search for users -->
    <form action="swimperformance.php" method="post">
            <?php
                include "./includes/swimdata_search_box.php"
            ?>
    </form>

    <!-- Search Results -->
    <?php
        include "./includes/swimdata_table.php";

    ?>

</div>

<div class="content-footer">
</div>



<?php 
    // Import Footer
    require "./Includes/footer.php"
?>