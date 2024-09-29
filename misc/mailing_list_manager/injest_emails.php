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

// Validate the POST request
if (!isset($_POST['data']) || !isset($_POST['key'])) {
    http_response_code(400);
    exit('Missing required parameters');
}

$data = json_decode($_POST['data'], true);
$key = $_POST['key'];

// Check if "data" is a valid JSON object
if ($data === null || !isset($data['subscriptions']) || !is_array($data['subscriptions'])) {
    http_response_code(400);
    exit('Invalid data format');
}

// Get the environment variable
$mailApiKey = getenv('MAILAPIKEY');
if ($mailApiKey === false) {
    http_response_code(500);
    exit('Environment variable MAILAPIKEY is not set');
}

// Get the current UTC time in milliseconds
$currentTimeInMilliseconds = round(microtime(true) * 1000);

// Round to the nearest 10 minutes (600,000 milliseconds)
$roundedTimeInMilliseconds = round($currentTimeInMilliseconds / 600000) * 600000;

// Concatenate MAILAPIKEY and the rounded time in milliseconds
$expectedString = $mailApiKey . $roundedTimeInMilliseconds;

// Compute the SHA256 hash
$expectedHash = hash('sha256', $expectedString);

// Verify the provided key
if ($expectedHash !== $key) {
    http_response_code(401);
    exit('Unauthorized');
}

// Prepare the SQL statement for insertion
$sql = "INSERT INTO mailing_list (email, email_hash, preferences) VALUES (:email, :email_hash, :preferences)
        ON DUPLICATE KEY UPDATE preferences = VALUES(preferences)";
$stmt = $pdo->prepare($sql);

// Insert each subscription object into the database
foreach ($data['subscriptions'] as $subscription) {
    if (!isset($subscription['email']) || !isset($subscription['preferences'])) {
        http_response_code(400);
        exit('Invalid subscription data');
    }

    $email = filter_var($subscription['email'], FILTER_VALIDATE_EMAIL);
    $preferences = filter_var($subscription['preferences'], FILTER_VALIDATE_INT);

    if ($email === false || $preferences === false) {
        http_response_code(400);
        exit('Invalid email or preferences value');
    }

    $email_hash = hash('sha256', $email.'iamthewalrus');

    try {
        $stmt->execute([
	    ':email' => $email,
            ':email_hash' => $email_hash,
	    ':preferences' => $preferences,
        ]);
    } catch (PDOException $e) {
        http_response_code(500);
        exit('Database error: ' . $e->getMessage());
    }
}

// Respond with a success message
http_response_code(200);
echo json_encode(['status' => 'success']);
?>

