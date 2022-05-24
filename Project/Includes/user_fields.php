<div class="profile-group">
    <div class="profile-label">
        <h3>User Name</h3>
    </div>    
    <div class="profile-data">
        <input type="text" <?php if (isset($_SESSION['role']) && $_SESSION['role'] == "Swimmer" && isset($_SESSION['parent_id'])) {echo 'readonly ';} ?> name="userName" value="<?php if(isset($row['UUID'])) {echo $row['user_name']; } ?>" class="input-controls">
    </div>    
</div>
<!-- Email address -->
<div class="profile-group">
    <div class="profile-label">
        <h3>Email Address</h3>
    </div>    
    <div class="profile-data">
        <input type="email" <?php if (isset($_SESSION['role']) && $_SESSION['role'] == "Swimmer" && isset($_SESSION['parent_id'])) {echo 'readonly ';} ?>  name="emailAddress" value="<?php if(isset($row['UUID'])) {echo $row['email_address']; } ?>" class="input-controls">
    </div>    
</div>
<!-- First Name -->
<div class="profile-group">
    <div class="profile-label">
        <h3>First Name</h3>
    </div>    
    <div class="profile-data">
        <input type="text" <?php if (isset($_SESSION['role']) && $_SESSION['role'] == "Swimmer" && isset($_SESSION['parent_id'])) {echo 'readonly ';} ?> name="firstName" value="<?php if(isset($row['UUID'])) {echo $row['first_name']; } ?>" class="input-controls">
    </div>    
</div>
<!-- Last Name -->
<div class="profile-group">
    <div class="profile-label">
        <h3>Last Name</h3>
    </div>    
    <div class="profile-data">
        <input type="text" <?php if (isset($_SESSION['role']) && $_SESSION['role'] == "Swimmer" && isset($_SESSION['parent_id'])) {echo 'readonly ';} ?> name="lastName" value="<?php if(isset($row['UUID'])) {echo $row['surname']; } ?>" class="input-controls">
    </div>    
</div>
<!-- Date of Birth -->
<div class="profile-group">
    <div class="profile-label">
        <h3>Date of Birth</h3>
    </div>    
    <div class="profile-data">
        <input type="date" <?php if (isset($_SESSION['role']) && $_SESSION['role'] == "Swimmer" && isset($_SESSION['parent_id'])) {echo 'readonly ';} ?> name="dateOfBirth" value="<?php if(isset($row['UUID'])) {echo $row['date_of_birth']; } ?>" max="<?php echo date("Y-m-d"); ?>" class="input-controls">
    </div>    
</div>
<!-- Telephone numnber -->
<div class="profile-group">
    <div class="profile-label">
        <h3>Telephone Number</h3>
    </div>    
    <div class="profile-data">
        <input type="tel" <?php if (isset($_SESSION['role']) && $_SESSION['role'] == "Swimmer" && isset($_SESSION['parent_id'])) {echo 'readonly ';} ?> name="phoneNumber" value="<?php if(isset($row['UUID'])) {echo $row['telephone_number']; } ?>" class="input-controls">
    </div>    
</div>
<!-- Address -->
<div class="profile-group">
    <div class="profile-label">
        <h3>Address Line 1</h3>
    </div>    
    <div class="profile-data">
        <input type="text" <?php if (isset($_SESSION['role']) && $_SESSION['role'] == "Swimmer" && isset($_SESSION['parent_id'])) {echo 'readonly ';} ?> name="addressLine1" value="<?php if(isset($row['UUID'])) {echo $row['address_line_1']; } ?>" class="input-controls">
    </div>    
</div>
<div class="profile-group">
    <div class="profile-label">
        <h3>Address Line 2</h3>
    </div>    
    <div class="profile-data">
        <input type="text" <?php if (isset($_SESSION['role']) && $_SESSION['role'] == "Swimmer" && isset($_SESSION['parent_id'])) {echo 'readonly ';} ?> name="addressLine2" value="<?php if(isset($row['UUID'])) {echo $row['address_line_2']; } ?>" class="input-controls">
    </div>    
</div>
<div class="profile-group">
    <div class="profile-label">
        <h3>Town</h3>
    </div>    
    <div class="profile-data">
        <input type="text" <?php if (isset($_SESSION['role']) && $_SESSION['role'] == "Swimmer" && isset($_SESSION['parent_id'])) {echo 'readonly ';} ?> name="town" value="<?php if(isset($row['UUID'])) {echo $row['town']; } ?>" class="input-controls">
    </div>    
</div>
<div class="profile-group">
    <div class="profile-label">
        <h3>City</h3>
    </div>    
    <div class="profile-data">
        <input type="text" <?php if (isset($_SESSION['role']) && $_SESSION['role'] == "Swimmer" && isset($_SESSION['parent_id'])) {echo 'readonly ';} ?> name="city" value="<?php if(isset($row['UUID'])) {echo $row['city']; } ?>" class="input-controls">
    </div>    
</div>
<div class="profile-group">
    <div class="profile-label">
        <h3>County</h3>
    </div>    
    <div class="profile-data">
        <input type="text" <?php if (isset($_SESSION['role']) && $_SESSION['role'] == "Swimmer" && isset($_SESSION['parent_id'])) {echo 'readonly ';} ?> name="county" value="<?php if(isset($row['UUID'])) {echo $row['county']; } ?>" class="input-controls">
    </div>    
</div>
<div class="profile-group">
    <div class="profile-label">
        <h3>Post Code</h3>
    </div>    
    <div class="profile-data">
        <input type="text" <?php if (isset($_SESSION['role']) && $_SESSION['role'] == "Swimmer" && isset($_SESSION['parent_id'])) {echo 'readonly ';} ?> name="postCode" value="<?php if(isset($row['UUID'])) {echo $row['post_code']; } ?>" class="input-controls">
    </div>    
</div>
<div class="profile-group">
    <div class="profile-label">
        <h3>Account Type</h3>
    </div>    
    <div class="profile-data">
        <?php
            if($_SESSION['role'] != "Club Official") {
                echo "
                    <input type='text' readonly name='accountSelection' value='"; 
                        if(isset($row['UUID'])) {
                            echo $row['role'];
                         } 
                        echo "' class='input-controls'>
                "; 
            } else {
                echo "
                    <select name='accountSelection' value='"; if(isset($row['UUID'])) {echo $row['role'];} echo "' class='input-controls'>
                        <option "; if (!isset($row)) {echo "selected ";} echo "readonly value='None'>Select an option...</option>";
                            
                                // Get roles from DB
                                $roleSQL = "SELECT role_name FROM roles";
                                $roleQuery = mysqli_query($connection, $roleSQL);
                                if(!$roleQuery) {
                                    die("Query failed ". mysqli_error($connection));       
                                } else {
                                    while($roleRow = mysqli_fetch_assoc($roleQuery)) {
                                        echo "
                                            <option "; 
                                            if (isset($row["role"]) && $row["role"] == $roleRow['role_name']) {
                                                echo "selected ";
                                            }; 
                                            if (isset($_GET['type']) && returnCleanUserData($_GET['type']) == "linkedAccount") {
                                                if($roleRow['role_name'] != "Swimmer") {
                                                    echo "disabled ";
                                                }
                                            }
                                            echo "
                                            value='{$roleRow['role_name']}'>{$roleRow['role_name']}</option>                
                                        ";
                                    }
                                }
                            echo "
                    </select>                  
                ";
            }
        ?>  
    </div>    
</div>
<div class="profile-group">
    <div class="profile-label">
        <h3>My Coach</h3>
    </div>    
    <div class="profile-data">
            <?php

                if($_SESSION['role'] != "Club Official" && $_SESSION['role'] != "Coach") {
                    //If user is swimmer or parent then they should not be able to change coach - just see coach name
                    echo "
                        <select name='coachSelection' value='"; if(isset($row['UUID'])) {echo $row['coach_id']; } echo "' class='input-controls'>";
                            if(isset($row['UUID'])) {
                                $coachSQL = "SELECT UUID, user_name FROM users WHERE UUID = '{$row['coach_id']}'";
                                $coachNameQuery = mysqli_query($connection, $coachSQL);
                                if(!$coachNameQuery) {
                                    die("Query failed " . mysqli_error($connection));
                                } else {
                                    $coachrow = mysqli_fetch_assoc($coachNameQuery);
                                    echo "
                                        <option selected value={$coachrow['UUID']}>{$coachrow['user_name']}</option>
                                    ";
                                }
                            }
                            
                            echo "
                        </select>
                        ";
                } else {
                    // Coach / Club Officials should be able to change coach name to move swimmers to different squads - so should see the drop down selection box
                    echo "
                    
                    <select name='coachSelection' value='"; if(isset($row['UUID'])) {echo $row['coach_id']; } echo "' class='input-controls'>
                    <option "; if(!isset($row)) {echo "selected ";} echo " value='None'>Select an option...</option>
                    <option "; if (isset($row['coach_id']) && $row['coach_id'] == "Not Applicable") {echo "selected ";} echo "value='Not Applicable'>Not Applicable</option>";
                        $coachSQL = "SELECT UUID, user_name FROM users WHERE role = 'Coach'";
                        $coachQuery = mysqli_query($connection, $coachSQL);
                        if(!$coachQuery) {
                            die("Query failed ". mysqli_error($connection));       
                        } else {
                            while($coachRow = mysqli_fetch_assoc($coachQuery)) {
                                echo "
                                    <option ";
                                    if (isset($row['coach_id']) && $coachRow['UUID'] == $row['coach_id']) {
                                        echo "selected ";
                                    }
                                    echo "
                                    value='{$coachRow['UUID']}'>{$coachRow['user_name']}</option>
                                ";
                            }
                        }
    
                    echo "
                </select>";
                }

            ?>
    </div>    
</div>


<?php 
    if(isset($row['role'])) {
        if ($row['role'] == "Parent") {
            
            // DB Query to find any existing records linked to parent
            $sqlstatement = "SELECT * FROM users WHERE parent_id = '{$row['UUID']}'";
            $query = mysqli_query($connection, $sqlstatement);
            if(!$query) {
                die ("Query Failed: " . mysqli_error());
            }; 

            echo "
                <div class='linked-account-section'>
                    <div>
                        <h2>Linked Accounts</h2>
                    </div>                    
                    <div id='linkedAccounts'>
                        <table class='user-table'>
                            <thead>
                                <th>User Name</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Date of Birth</th>
                                <th class='table-icons'>Edit</th>";
                                if (isset($_SESSION['role']) && $_SESSION['role'] == "Club Official") {
                                    // Only club officials can delete accounts
                                    echo "
                                        <th class='table-icons'>Delete</th>    
                                    ";
                                }
                                
                            echo "
                            </thead>                            
                            <tbody>";
                                while ($linkedAccountRow = mysqli_fetch_assoc($query)) {
                                    $adjustedDate = date("d/m/Y", strtotime($linkedAccountRow['date_of_birth']));
                                    echo "
                                        <tr>
                                            <td>{$linkedAccountRow['user_name']}</td>
                                            <td>{$linkedAccountRow['first_name']}</td>
                                            <td>{$linkedAccountRow['surname']}</td>
                                            <td>{$adjustedDate}</td>
                                            <td class='table-icons'><a class='user-icons' href='./edituser.php?id={$linkedAccountRow['UUID']}'><i class='fas fa-edit'></i></a></td>";
                                            if (isset($_SESSION['role']) && $_SESSION['role'] == "Club Official") {
                                                // Only club officials can delete accounts
                                                echo "
                                                    <td class='table-icons'><a class='user-icons' href='./deleteaccount.php?source=viewusers&id={$linkedAccountRow['UUID']}'><i class='fas fa-trash'></i></a></td>    
                                                ";
                                            }                                        
                                        echo "
                                        </tr>        
                                    ";
                                }
                                echo "
                            </tbody>                                    
                        </table>
                    </div>";    
                    if (isset($_SESSION['role']) && $_SESSION['role'] == "Club Official" ) {
                        // Only club officials should be able to add a linked account.
                        echo "
                            <a class='colourButton' href='./newuser.php?type=linkedAccount&id={$row['UUID']}&parentUserName={$row['user_name']}'>Add new linked account</a>    
                        ";
                    }    
                    echo "
                    </div>
            ";
        } 
        if ($row['role'] == "Swimmer") {
            // If user is a swimmer then display their race performance & training performance
            
            echo "
            <div class='training-and-race-data'>
                <div>
                    <h2>My Race Performance</h2>
                </div>
                <div id='races'>
                    <table class='race-table'>
                        <thead>
                            <th>Race Name</th>
                            <th>Race Date</th>
                            <th>Distance</th>
                            <th>Time</th>";
                            if (isset($_SESSION['role'])) {
                                if($_SESSION['role'] == "Club Official" || $_SESSION['role'] == "Coach") {
                                    echo "
                                        <th class='table-icons'>Edit</th>
                                        <th class='table-icons'>Delete</th>        
                                    ";
                                }
                            }
                            echo "
                        </thead>                            
                        <tbody>";

                            // PHP QUERY FOR LINKED RACES
                            $raceSQL = "SELECT * FROM race_performance INNER JOIN races ON race_performance.race_id = races.race_id WHERE race_performance.swimmer_id = '{$row['UUID']}' ORDER BY races.race_date DESC";
                            $raceperformanceQuery = mysqli_query($connection, $raceSQL);
                            if(!$raceperformanceQuery) {
                                die("Query failed ". mysqli_error($connection));       
                            } else {
                                while ($raceRow = mysqli_fetch_assoc($raceperformanceQuery)) {
                                    $adjustedDate = date("d/m/Y", strtotime($raceRow['race_date']));
                                    echo "
                                        <tr>
                                            <td>{$raceRow['race_name']}</td>
                                            <td>{$adjustedDate}</td>
                                            <td>{$raceRow['race_length']}</td>
                                            <td>{$raceRow['performance']}</td>";
                                            if (isset($_SESSION['role'])) {
                                                if($_SESSION['role'] == "Club Official" || $_SESSION['role'] == "Coach") {
                                                    echo "
                                                        <td class='table-icons'><a class='user-icons' href='./editraceperformance.php?raceid={$raceRow['race_id']}&userid={$row['UUID']}'><i class='fas fa-edit'></i></a></td>
                                                        <td class='table-icons'><a class='user-icons' href='./deleteraceperformance.php?raceid={$raceRow['race_performance_id']}&userid={$row['UUID']}'><i class='fas fa-trash'></i></a></td>
                                                    ";
                                                }
                                            }
                                            echo "
                                        </tr>        
                                    ";
                                }
                            }
                            echo "
                        </tbody>                                    
                    </table>
                </div>";
                // Comment in when development work complete so that only coaches and club officials can add race data
                if (isset($_SESSION['role'])) {
                    if($_SESSION['role'] == "Club Official" || $_SESSION['role'] == "Coach") {
                        echo "
                            <a class='colourButton' href='./searchraceperformance.php?id={$row['UUID']}'>Add race data</a>
                        ";
                    };
                }
                echo "
            </div>
            ";
            


        }
    }
?>

<?php


    

