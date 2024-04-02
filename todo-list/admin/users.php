<?php
    session_start();
    // Check if the user is logged in
    if (!isset($_SESSION['userid'])) {
        header("Location: /");
        exit();
    }

    require_once '../config.php';
    // Create logs with given information
    require_once __ROOT__ . '/log/log.php';
    require_once __ROOT__ . '/fw/db.php';

    $stmt = new Stmt("SELECT roles.title FROM users inner join permissions on users.ID = permissions.userID inner join roles on permissions.roleID = roles.ID WHERE users.username = ?");
    $stmt = $stmt->bindString($_SESSION['username'])->execute();
    $stmt->bind_result($db_allowed);
    $stmt->fetch();
    if ($db_allowed != "Admin") {
        exit();
    }

    $stmt = new Stmt("SELECT users.ID, users.username, users.password, roles.title FROM users inner join permissions on users.ID = permissions.userID inner join roles on permissions.roleID = roles.ID order by username");
    $stmt = $stmt->execute();
    // Bind the result variables
    $stmt->bind_result($db_id, $db_username, $db_password, $db_title);

    require_once '../fw/header.php';
?>
<h2>User List</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Role</th>
    </tr>
    <?php
        // Fetch the result
        while ($stmt->fetch()) {
            echo "<tr><td>$db_id</td><td>$db_username</td><td>$db_title</td><input type='hidden' name='password' value='$db_password' /></tr>";
        }
    ?>
</table>

<?php
    require_once '../fw/footer.php';
?>