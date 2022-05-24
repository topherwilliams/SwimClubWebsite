
<div id='searchResults'>
    <table class='user-table' id="sortable">
        <thead>
            <th onclick="sortBy(0)">Position</th>
            <th onclick="sortBy(1)">Time</th>
            <th onclick="sortBy(2)">Distance</th>
            <th onclick="sortBy(3)">Speed</th>
            <th onclick="sortBy(4)">Name</th>
            <th onclick="sortBy(5)">Race Date</th>
            <th onclick="sortBy(6)">Race Name</th>

            
        </thead>                            
        <tbody>
            <?php
                
                if($validSearch == false) {
                    echo "
                        <tr><td><h3 class='error_text' >No Search Results Found.</h3></td></tr>
                    ";
                } else {
                    $x = 0;
                    while ($rows = mysqli_fetch_assoc($query)) {              
                        $x ++;
                        $adjustedDate = date("d/m/Y", strtotime($rows['race_date']));
                        $fullName = $rows['first_name'] . " " . $rows['surname'];
                        echo "
                            <tr"; 
                                if ($rows['UUID'] == $_SESSION['id']) {
                                    echo " style='font-weight:bold; color:var(--dark-green);'";
                                }
                            echo ">
                                <td>{$x}</td>
                                <td>{$rows['performance']}s</td>
                                <td>{$rows['race_length']}m</td>
                                <td>{$rows['metres_per_second']} m/s</td>
                                <td>{$fullName}</td>
                                <td>{$adjustedDate}</td>
                                <td>{$rows['race_name']}</td> 
                            </tr>        
                        ";
                    }
                }
            ?>
            
        </tbody>                                    
    </table>
</div>    