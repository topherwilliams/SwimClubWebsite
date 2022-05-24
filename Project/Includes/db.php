<?php
    // Set connection details as variables to make easier to reuse
    $db['db_host'] = 'localhost';
    $db['db_user'] = 'root';
    $db['db_pass'] = '';
    $db['db_name'] = 'swim_club';
    foreach($db as $key => $value) {
        // Convert array values into constants
        define(strtoupper($key), $value);
    };
    
    $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);


?>