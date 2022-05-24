<?php

    session_start();

    // Clear session settings
    $_SESSION['username'] = NULL;
    $_SESSION['firstname'] = NULL;
    $_SESSION['lastname'] = NULL;
    $_SESSION['role'] = NULL;   

    setcookie(session_name(), '', 100);
    session_unset();
    session_destroy();

    header("Location: ./login.php");

?>