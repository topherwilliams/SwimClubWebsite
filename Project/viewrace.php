<?php 
    // This file is the main window content for the site, from where all functions are accessible.
    
    // DB Functions / session import here 

    require "./Includes/header.php";

    if(isset($_GET['id'])) {
        // Get race details
        $validSearch = true;
        $raceID = returnCleanUserData($_GET['id']);
        $raceDetailsSQL = "SELECT * FROM races WHERE race_id = '{$raceID}' ";
        $raceDetailsQuery = mysqli_query($connection, $raceDetailsSQL);
        if(!$raceDetailsQuery) {
            die("Query failed ". mysqli_error($connection));       
        } else {
            $row = mysqli_fetch_assoc($raceDetailsQuery);
            // Get swimmer data for race
            $raceSwimmerSQL = "SELECT * FROM race_performance INNER JOIN users on race_performance.swimmer_id = users.uuid WHERE race_performance.race_id = '{$raceID}' ORDER BY race_performance.Performance ASC ";
            $raceSwimmerQuery = mysqli_query($connection, $raceSwimmerSQL);
            if(!$raceSwimmerQuery) {
                die("Query failed ". mysqli_error($connection));       
            } else {
                if(mysqli_num_rows($raceSwimmerQuery) < 1) {
                    $validSearch = false;
                }
            }
        }
    } else {
        $validSearch = false;
    }

?>

<div class="content-header">
    <h1><a href="./searchraces.php?id=<?php echo $row['race_id'] ?>"><i class="fas fa-arrow-left header-navigation-icon"></i></a>RACE DETAILS</h1>
</div>

<div id="race-details">
    <!-- Race Information Here -->
    <div id="search-fields" style="display: flex;">
        <div style="width:50%">
            <h1><?php echo strtoupper($row['race_name']) ?></h1>
        </div>
        <div style="text-align:right; width:50%">
            <h3><?php echo strtoupper($row['race_pool']) . ", " . strtoupper($row['race_town']) ?></h3>
            <h3><?php echo date("d/m/Y", strtotime($row['race_date'])) ?></h3>
            <h4><?php echo $row['race_length'] . "m" ?></h4>    
        </div>
        

    </div>

</div>
    
<div id="race-results">
    <!-- Race Result Table Here -->
    <div id='searchResults'>
        <table class='user-table'>
            <thead>
                <th>Position</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Time (Seconds)</th>
            </thead>                            
            <tbody>
                <?php
                    
                    if($validSearch == false) {
                        echo "
                            <tr><td><h3 class='error_text' >No Race Results Found.</h3></td></tr>
                        ";
                    } else {
                        $x = 0;
                        while ($swimmerRows = mysqli_fetch_assoc($raceSwimmerQuery)) {              
                            $x++;

                            echo "
                                <tr>
                                    <td>{$x}</td>
                                    <td>{$swimmerRows['first_name']}</td>
                                    <td>{$swimmerRows['surname']}</td>
                                    <td>{$swimmerRows['performance']}</td>
                                </tr>        
                            ";
                        }
                    }
                ?>
                
            </tbody>                                    
        </table>
    </div>    

</div>


<?php 
    // Import Footer
    require "./Includes/footer.php"
?>