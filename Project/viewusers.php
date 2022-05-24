<?php 
    require "./Includes/header.php";

    if(isset($_SESSION['role']) && $_SESSION['role'] != "Club Official") {
        header("Location: profile.php?error=access");
    }

    $pageSource = "viewusers";

    // Add validation in here once login / sessions are built so that only club official roles can view all members

    if(isset($_POST['searchUsers'])) {
        $validSearch = false;
        // Assemble SQL Query Dynamically
        $postCode = strtoupper(returnCleanUserData($_POST['post_code']));
        $userName = returnCleanUserData($_POST['user_name']);
        $emailAddress = strtolower(returnCleanUserData($_POST['email_address']));
        if ($_POST['roleSearch'] != "None") {
            $role = returnCleanUserData($_POST['roleSearch']);
        } else { $role = NULL; }
        
        if ($role || $postCode || $userName || $emailAddress) {
            // Only do search if values entered in one or more search fields
            $validSearch = true;
            $whereArr = array();
            if($postCode) {
                $whereArr[] = "post_code LIKE '{$postCode}'";
            }
            if($userName) {
                $whereArr[] = "user_name LIKE '{$userName}'";
            }
            if($emailAddress) {
                $whereArr[] = "email_address LIKE '{$emailAddress}'";
            }
            if($role) {
                $whereArr[] = "role = '{$role}'";
            }
    
            $whereStr = implode(" AND ", $whereArr);
            $sqlstatement = "SELECT * FROM users WHERE {$whereStr}";
    
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

    if(isset($_GET['searchID'])) {
        //Reference passed back from editing a user so show that user in search
        $validSearch = true;
        $id = returnCleanUserData($_GET['searchID']);
        $sqlstatement = "SELECT * FROM users WHERE UUID = '{$id}'";
        $query = mysqli_query($connection, $sqlstatement);
        if(!$query) {
            die("Query failed ". mysqli_error($connection));       
        } 
    }
    
?>


<div class="content-header">
    <h1><a href="./siteadmin.php"><i class="fas fa-arrow-left header-navigation-icon"></i></a>SEARCH / EDIT USERS</h1>
</div>

<div class="content-maincontent">
    
    <!-- Form to search for users -->
    <form action="viewusers.php" method="post">
        <div id="search-fields">
            <div>
                <h3>Search Filters:</h3>
            </div>
            <div id="search-options">
                <div class="search-option">
                    <input name="user_name" class="search-input" type="text" placeholder="User Name...">
                </div>
                <div class="search-option">
                    <input name="email_address" class="search-input" type="email" placeholder="Email Address...">
                </div>
                <div class="search-option">
                    <input name="post_code" class="search-input" type="text" placeholder="Post Code...">
                </div>
                <div class="search-option">
                    <select name="roleSearch" class="search-input">
                        <option selected value="None">Role...</option>
                        
                            <?php
                                // Get roles from DB
                                $roleSQL = "SELECT role_name FROM roles";
                                $roleQuery = mysqli_query($connection, $roleSQL);
                                if(!$roleQuery) {
                                    die("Query failed ". mysqli_error($connection));       
                                } else {
                                    while($roleRow = mysqli_fetch_assoc($roleQuery)) {
                                        echo "
                                            <option value='{$roleRow['role_name']}'>{$roleRow['role_name']}</option>                
                                        ";
                                    }
                                }
                            ?>

                    </select>    
                </div>
                <button class="colourButton colourButton-Small" name="searchUsers">Search</button>
            </div>
            <div hidden id="advanced-search">
                <span class="sort-option">
                    <select class="sort-input" name="sort_column" id="">
                        <option selected value="None">Column to sort by...</option>    
                        <option value="">User Name</option>
                        <option value="">First Name</option>
                        <option value="">Last Name</option>
                        <option value="">Date Of Birth</option>
                        <option value="">Email Address</option>
                        <option value="">Parent</option>
                    </select>
                </span>
                <span class="sort-option">
                    <select class="sort-input" name="sort_direction" id="">
                        <option selected value="None">Sort direction...</option>        
                        <option value="Asc">Ascending</option>
                        <option value="Desc">Descending</option>
                    </select>
                </span>
            </div>
        </div>
    </form>

    <!-- Search Results -->
    <?php
    include "./includes/user_table.php";
    ?>


</div>

<div class="content-footer">
</div>



<?php 
    // Import Footer
    require "./Includes/footer.php"
?>