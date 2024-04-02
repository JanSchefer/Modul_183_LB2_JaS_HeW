<?php
    require_once 'log/log.php';
    session_start();

    $log->info("User with username '" . $_SESSION['username'] . "' logged out");
    
    session_unset();
    session_destroy();

    header("Location: /");
    
    exit();
?>