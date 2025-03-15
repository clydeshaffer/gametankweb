<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    setcookie(session_name(), '', 100);
    session_unset();
    session_destroy();
    $_SESSION = array();
    http_response_code(200);
    echo json_encode(['status' => 'success', 'message' => 'Logged out successfully']);
} else if ($_SERVER["REQUEST_METHOD"] == "GET") {
    <form action="logout.php" style="border:1px solid #ccc">
  <div class="container">
    <h1>Log out?</h1>

    <div class="clearfix">
      <button type="submit" class="signupbtn">Log Out</button>
    </div>
  </div>
</form>
}

?>