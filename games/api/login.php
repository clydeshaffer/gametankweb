<?php

include '../../include/db.php';

session_start();

if (isset($_SESSION['user'])) {
    http_response_code(200);
    exit('Already logged in');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $db = get_db("games");

    $sql = 'SELECT userID, passhash, handle from users where handle = :handle';

    $statement = $db->prepare($sql);

    try {
        $statement->execute([
            ':handle' => $_POST['handle']
        ]);

        if ($statement->rowCount() > 0) {
            $statement->bind_result($id, $passhash, $handle);
            if($statement->fetch()) {
                if(password_verify($_['password'], $passhash)) {
                    http_response_code(200);
                    echo json_encode(['status' => 'success', 'message' => 'Logged in successfully']);

                    $_SESSION["user"] = $id;
                    $_SESSION["myhandle"] = $handle;
                    $_SESSION["start_time"] = time();

                    exit();
                }
            }
        }
        http_response_code(401);
        echo json_encode(['status' => 'error', 'message' => 'Could not log in']);
    } catch (PDOException $e) {
        http_response_code(500);
        exit('IDK something went sideways: ' . $e->getMessage());
    }
    
} else if($_SERVER["REQUEST_METHOD"] == "GET") {
    ?>

<form action="login.php" style="border:1px solid #ccc" method="post">
  <div class="container">
    <h1>Log In</h1>
    <hr>

    <label for="handle"><b>Login name</b></label>
    <input type="text" placeholder="Enter username" name="handle" required>
    <label for="password"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="password" required>

    <div class="clearfix">
      <button type="submit" class="signupbtn">Log In</button>
    </div>
  </div>
</form>

    <?php
}
?>