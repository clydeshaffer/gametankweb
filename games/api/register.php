<?php

include '../../include/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if($_POST['password'] != $_POST['password-repeat']) {
        http_response_code(400);
        exit('Passwords did not match');
    }

    $db = get_db("games")

    $sql = "INSERT into users (displayName, handle, passhash) values (:displayName, :handle, :passhash)"

    $statement = $db->prepare($sql)

    $hash = password_hash($_POST['password']);

    try {
        $statement->execute([
            ':displayName' => $_POST['displayName'],
            ':handle' => $_POST['handle'],
            ':passhash' => $hash
        ]);

        if ($statement->rowCount() > 0) {
            http_response_code(200);
            echo json_encode(['status' => 'success', 'message' => 'Successfully registered']);
        } else {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'Could not register']);
        }
    } catch (PDOException $e) {
        http_response_code(500);
        exit('IDK something went sideways: ' . $e->getMessage());
    }
    
} else if($_SERVER["REQUEST_METHOD"] == "GET") {
    ?>

<form action="register.php" style="border:1px solid #ccc">
  <div class="container">
    <h1>Sign Up</h1>
    <p>Please fill in this form to create an account.</p>
    <hr>

    <label for="handle"><b>Login name</b></label>
    <input type="text" placeholder="Enter username" name="handle" required>

    <label for="displayName"><b>Display name</b></label>
    <input type="text" placeholder="Enter display name" name="displayName" required>

    <label for="password"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="password" required>

    <label for="password-repeat"><b>Repeat Password</b></label>
    <input type="password" placeholder="Repeat Password" name="password-repeat" required>

    <div class="clearfix">
      <button type="submit" class="signupbtn">Sign Up</button>
    </div>
  </div>
</form>

    <?php
}
?>