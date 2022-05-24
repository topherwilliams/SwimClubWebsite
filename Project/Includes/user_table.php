<!-- To use user table - hosting page must pass $query data to populate -->

    <div id='searchResults'>
        <table class='user-table' id="sortable">
            <thead>
                <th onclick="sortBy(0)">Username</th>
                <th onclick="sortBy(1)">First Name</th>
                <th onclick="sortBy(2)">Last Name</th>
                <th onclick="sortBy(3)">DOB</th>
                <th onclick="sortBy(4)">Age</th>
                <th onclick="sortBy(5)">Email</th>
                <th onclick="sortBy(6)">Access</th>
                <th onclick="sortBy(7)">Parent</th>
                <th>Status</th>
                <th class='table-icons'>Edit</th>
                <?php

                    if($_SESSION['role'] == "Club Official" ) {
                        echo "
                            <th class='table-icons'>Delete</th>        
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
                            $accountStatus = "<a href='./emailRegistration.php?id={$rows['UUID']}'><i class='fas fa-thumbs-up user-icons'></i></a>";
                            if($rows['account_locked'] == 1) { 
                                $accountStatus = "<a href='./emailRegistration.php?id={$rows['UUID']}'><i class='fas fa-lock user-icons'></i></a>";
                             };
                            if($rows['parent_id'] == NULL) {
                                // If no parent ID then don't search for name
                                $parentName = "";
                            } else {
                                // If parent_id then retrieve parent name.
    
                                $sqlGetParent = "SELECT user_name FROM users WHERE UUID = '{$rows['parent_id']}'";
                                $queryGetParent = mysqli_query($connection, $sqlGetParent);
                                if (!$queryGetParent) {
                                    die("Query failed ". mysqli_error($connection));       
                                } else {
                                    $parentRow = mysqli_fetch_assoc($queryGetParent);
                                    if ($parentRow) {
                                        $parentName = $parentRow['user_name'];
                                    } else {
                                        $parentName = "";
                                    }
                                    
                                }
                            }
                            
                            $adjustedDate = date("d/m/Y", strtotime($rows['date_of_birth']));
                            $birthday = $rows['date_of_birth'];
                            $currentDate = date("Y-m-d");
                            $age = date_diff(date_create($birthday), date_create($currentDate)) ->format("%y");
                            echo "
                                <tr>
                                    <td>{$rows['user_name']}</td>
                                    <td>{$rows['first_name']}</td>
                                    <td>{$rows['surname']}</td>
                                    <td>{$adjustedDate}</td>
                                    <td>{$age}</td>
                                    <td>{$rows['email_address']}</td>
                                    <td>{$rows['role']}</td>
                                    <td><a class='table-text-link' href='./edituser.php?id={$rows['parent_id']}'>{$parentName}</a></td>
                                    <td class='table-icons'>{$accountStatus}</td>
                                    <td class='table-icons'><a class='user-icons' href='./edituser.php?pagesource={$pageSource}&id={$rows['UUID']}'><i class='fas fa-edit'></i></a></td>";

                                    if($_SESSION['role'] == "Club Official" ) {
                                        echo "
                                        <td class='table-icons'><a class='user-icons' href='./deleteaccount.php?pagesource={$pageSource}&source=viewusers&id={$rows['UUID']}'><i class='fas fa-trash'></i></a></td>
                                        ";
                                    }

                                    echo"
                                </tr>        
                            ";
                        }

                    }

                    

                ?>
                
            </tbody>                                    
        </table>
    </div>    