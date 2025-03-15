<?php
// Database connection parameters from environment variables
$host = 'localhost';  // Adjust if necessary
$username = getenv('TACTICS_SQL_USER');
$password = getenv('TACTICS_SQL_PASS');


function get_db($dbname) {

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
    return $pdo;
}
?>