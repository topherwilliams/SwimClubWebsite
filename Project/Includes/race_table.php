
<div id='searchResults'>
    <table class='user-table' id="sortable">
        <thead>
            <th onclick="sortBy(0)">Race Name</th>
            <th onclick="sortBy(1)">Town</th>
            <th onclick="sortBy(2)">Pool</th>
            <th onclick="sortBy(3)">Race Length(m)</th>
            <th onclick="sortBy(4)">Race Date</th>

            <?php
                if ($tableType == "adminTable") {
                    echo "
                        <th class='table-icons'>Edit</th>
                        <th class='table-icons'>Delete</th>        
                    ";
                } else {
                    echo "
                        <th class='table-icons'>View Race Results</th>        
                    ";
                }
            ?>
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
                                <td>{$adjustedDate}</td> ";
                                    if ($tableType == "adminTable") {
                                        echo "
                                            <td class='table-icons'><a class='user-icons' href='./editrace.php?id={$rows['race_id']}'><i class='fas fa-edit'></i></a></td>
                                            <td class='table-icons'><a class='user-icons' href='./deleterace.php?id={$rows['race_id']}'><i class='fas fa-trash'></i></a></td>
                                        ";
                                    } else {
                                        echo "
                                            <td class='table-icons'><a class='user-icons' href='./viewrace.php?id={$rows['race_id']}'><i class='fas fa-stopwatch'></i></a></td>
                                        ";      
                                    }
                            echo "
                            </tr>        
                        ";
                    }
                }
            ?>
            
        </tbody>                                    
    </table>
</div>    