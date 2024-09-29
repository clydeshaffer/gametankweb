<?php
// Database connection parameters from environment variables
$host = 'localhost';  // Adjust if necessary
$dbname = 'mailing_list';
$username = getenv('TACTICS_SQL_USER');
$password = getenv('TACTICS_SQL_PASS');

// Check if environment variables are set
if ($username === false || $password === false) {
    http_response_code(500);
    exit('Database environment variables are not set');
}

// Connect to MySQL
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    exit('Database connection failed: ' . $e->getMessage());
}

// Validate the GET request
if (!isset($_GET['FOO']) || !isset($_GET['BAR'])) {
    http_response_code(400);
    exit('Missing required parameters');
}

// Parse the FOO parameter as an integer
$foo = filter_var($_GET['FOO'], FILTER_VALIDATE_INT);
$bar = $_GET['BAR'];

// Check if FOO is a valid integer
if ($foo === false) {
    http_response_code(400);
    exit('Invalid FOO parameter');
}

// Prepare the SQL statement for updating the unsubscribe status
$sql = "UPDATE mailing_list SET unsubscribe = true WHERE id = :id AND email_hash = :email_hash";
$stmt = $pdo->prepare($sql);

// Execute the update
try {
    $stmt->execute([
        ':id' => $foo,
        ':email_hash' => $bar,
    ]);
    
    // Check if any rows were affected
    if ($stmt->rowCount() > 0) {
        http_response_code(200);
        echo json_encode(['status' => 'success', 'message' => 'Successfully unsubscribed']);
    } else {
        http_response_code(404);
        echo json_encode(['status' => 'error', 'message' => 'No matching record found']);
    }
} catch (PDOException $e) {
    http_response_code(500);
    exit('Database error: ' . $e->getMessage());
}
?>

