<?php
    session_start();
    // Check if the user is logged in
    if (!isset($_SESSION['userid'])) {
        header("Location: /");
        exit();
    }
    $id = "";
    include 'fw/db.php';
    // see if the id exists in the database

    if (isset($_POST['id']) && strlen($_POST['id']) != 0){
        $id = $_POST["id"];
        $stmt = new Stmt("select ID, title, state from tasks where ID = ?");
        $stmt = $stmt->bindString($id)->execute();
        if ($stmt->num_rows == 0) {
            $id = "";
        }
    }
  
  require_once 'fw/header.php';
  if (isset($_POST['title']) && isset($_POST['state'])){
    $state = $_POST['state'];
    $title = $_POST['title'];
    $userid = $_SESSION['userid'];

    require_once 'log/log.php';
    
    // the if statement searches for "<script>" tags and deletes them if found.
    if ($id == "" && $title = htmlspecialchars(strip_tags($title))){
      $log->info("User with id '$userid' is creating a new task:"
        . "{ title: '$title', state: '$state', userID: '$userid' }");

      $stmt = new Stmt("insert into tasks (title, state, userID) values (?, ?, ?)");
      $stmt = $stmt->bindString($title)->bindString($state)->bindString($userid)->execute();

      $stmt = new Stmt("select MAX(ID) FROM tasks");
      $stmt = $stmt->execute();

      $stmt->bind_result($db_id);
      $stmt->fetch();

      $log->info("User with id '$userid' has created a new task:"
        . "{ id: '$db_id', title: '$title', state: '$state', userID: '$userid' }");
    }
    else if($title = htmlspecialchars(strip_tags($title))) {
      $stmt = new Stmt("select title, state, userID from tasks where id = ?");
      $stmt = $stmt->bindString($id)->execute();

      $stmt->bind_result($db_title, $db_state, $db_userid);
      $stmt->fetch();
      
      $log->info("User with id '$userid' is updating the task"
        . " { id: '$id' title: '$db_title', state: '$db_state', userID: '$db_userid' }"
        . " to: { id: '$id', title: '$title', state: '$state', userID: '$db_userid' }");

      $stmt = new Stmt("update tasks set title = ?, state = ? where ID = ?");
      $stmt = $stmt->bindString($title)->bindString($state)->bindString($id)->execute();

      $log->info("User with id '$userid' has updated the task"
      . " { id: '$id' title: '$db_title', state: '$db_state', userID: '$db_userid' }"
      . " to: { id: '$id', title: '$title', state: '$state', userID: '$db_userid' }");

    }else{
      $log->warning("User with id '$userid' tried to post an illegal statement");
    }

    echo "<span class='info info-success'>Update successfull</span>";
  }
  else {
    echo "<span class='info info-error'>No update was made</span>";
  } 

  require_once 'fw/footer.php';
?>
