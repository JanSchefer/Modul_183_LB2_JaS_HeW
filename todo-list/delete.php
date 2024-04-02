<?php
    session_start();
    // Check if the user is logged in
    if (!isset($_SESSION['userid'])) {
        header("Location: /");
        exit();
    }

    include 'fw/db.php';
    require_once 'fw/header.php';

    if (isset($_GET['id']) && strlen($_GET['id']) != 0) {
        require_once 'log/log.php';

        $id = $_GET["id"];

        $log->info("User '" . $_SESSION['username'] . "' is deleting task with id '" . $id . "'");
        
        $stmt = new Stmt("DELETE from tasks where ID = ?");
        $stmt = $stmt->bindString($id)->execute();

        $log->info("User '" . $_SESSION['username'] . "' has deleted task with id '" . $id . "'");

        echo "<span class='info info-success'>Delete successfull</span>";
    }

    require_once 'fw/footer.php';    
?>