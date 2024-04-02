<?php

    if (!isset($_GET["userid"]) || !isset($_GET["terms"])){
        die("Not enough information to search");
    }

    $userid = $_GET["userid"];
    $terms = $_GET["terms"];

    include '../../fw/db.php';
    include '../../log/log.php';

    $log->info("User with id '" . $userid . "' is searching for term: " . $terms);

    $stmt = new Stmt("select ID, title, state from tasks where userID = ? and title like '%?%'");
    $stmt = $stmt->bindString($userid)->bindString($terms)->execute();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($db_id, $db_title, $db_state);

        $result = 0;
        $max_results = 5;

        while ($stmt->fetch()) {
            echo $db_title . ' (' . $db_state . ')<br />';

            if ($result < $max_results) {
                $log->info("User with id '$userid' is searching for term '$terms' "
                    . " and got: { id: '$db_id', title: '$db_title', state: '$db_state' }");
            }
            $result = $result + 1;
        }

        if ($result >= $max_results) {
            $log->info("User with id '$userid' is searching for term '$terms' "
            . " and got: (" . $result - $max_results . " more)");
        }
    } else {
        $log->warning("User with id '" . $userid . "' is searching for term '" . $terms . "' and got no results");
    }
?>