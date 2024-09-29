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
$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['content']) || !isset($data['email_type']) || !isset($data['password']) || !isset($data['subject'])) {
    http_response_code(400);
    exit('Missing required parameters');
}

$content = $data['content'];
$email_type = filter_var($data['email_type'], FILTER_VALIDATE_INT);
$subject = $data['subject'];
$password = $data['password'];

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

// Verify the provided password
if ($expectedHash !== $password) {
    http_response_code(401);
    exit('Unauthorized');
}

// Define the bitmask values for each preference type
$bitmaskMap = [
    0 => 0,  // "Restock notification"
    1 => 1,  // "Announcements when new products are added"
    2 => 2   // "Newsletter about latest developments related to the GameTank"
];

// Get the matching bitmask
$matchingBitmask = $bitmaskMap[$email_type] ?? null;
if ($matchingBitmask === null) {
    http_response_code(400);
    exit('Invalid email type');
}

// Prepare the SQL statement for fetching emails
$sql = "SELECT id, email, email_hash FROM mailing_list WHERE (preferences & :preferences) = :preferences AND unsubscribe = false";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':preferences', $matchingBitmask, PDO::PARAM_INT);

// Execute the query
$stmt->execute();
$recipients = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Check if we have emails to send
if (empty($recipients)) {
    http_response_code(404);
    exit('No recipients found');
}

function signEmail($to, $subject, $body, $privateKeyPath, $domain, $selector, $headers) {

    // Create the canonicalized headers
    $canonicalizedHeaders = "from: noreply@mail.gametank.zone\r\n"; // From header included by default
    $canonicalizedHeaders .= "to: $to\r\n";
    $canonicalizedHeaders .= "subject: $subject\r\n";

    // Split headers into lines and canonicalize them
    $headerLines = explode("\r\n", trim($headers));
    foreach ($headerLines as $line) {
        $parts = explode(':', $line, 2);
        if (count($parts) === 2) {
            $canonicalizedHeaders .= strtolower(trim($parts[0])) . ": " . trim($parts[1]) . "\r\n";
        }
    }

    // Combine headers and body for canonicalization
    $canonicalizedBody = $canonicalizedHeaders . "\r\n" . $body;

    // Create the DKIM signature
    $dkimHeader = "DKIM-Signature: v=1; a=rsa-sha256; d=$domain; s=$selector; " .
                  "h=from:to:subject:" .
                  implode(':', array_map('strtolower', array_keys(parseHeaders($headers)))) . "; " .
                  "bh=" . base64_encode(hash('sha256', $body, true)) . "; " .
                  "b=" . base64_encode(sign($canonicalizedHeaders, $privateKeyPath)) . "\r\n";

    // Append DKIM signature to headers
    $headers .= $dkimHeader;

    //error_log($dkimHeader);

    // Send the email using the mail() function
    if (mail($to, $subject, $body, $headers)) {
        echo "Email sent successfully.";
    } else {
        echo "Email sending failed.";
    }
}

function sign($data, $privateKeyPath) {
    $privateKey = file_get_contents($privateKeyPath); // Read the private key from file
    $privateKeyResource = openssl_pkey_get_private($privateKey); // Create a private key resource
    openssl_sign($data, $signature, $privateKeyResource, OPENSSL_ALGO_SHA256); // Sign the data
    return $signature; // Return the signature
}

function parseHeaders($headers) {
    $result = [];
    foreach (explode("\r\n", trim($headers)) as $header) {
        $parts = explode(':', $header, 2);
        if (count($parts) === 2) {
            $result[trim($parts[0])] = trim($parts[1]);
        }
    }
    return $result;
}

// Send the email (simplified; use a mailer library for production)
$senderEmail = 'noreply@mail.gametank.zone'; // Set sender email
foreach ($recipients as $recipient) {
    // Create unsubscribe link
    $unsubscribeLink = "https://gametank.zone/misc/mailing_list_manager/unsubscribe.php?FOO=" . $recipient['id'] . "&BAR=" . $recipient['email_hash'];
    
    // Append unsubscribe link to email content
    $contentWithUnsubscribe = "<html>" . $content . "\r\n\r\n<br><br><a href=\"$unsubscribeLink\">Click here to unsubscribe</a></html>";

    $textContent = strip_tags($contentWithUnsubscribe);


    // Prepare headers
    $headers = "From: noreply@mail.gametank.zone\r\n";
    $headers .= "Reply-To: noreply@mail.gametank.zone\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: multipart/alternative; boundary=\"boundary\"\r\n";
    $headers .= "List-Unsubscribe: <https://gametank.zone/misc/mailing_list_manager/unsubscribe.php?FOO=UNSUBSCRIBE_ID&BAR=EMAIL_HASH>\r\n"; // Modify accordingly
    
    // Compose email body
    $message = "--boundary\r\n";
    $message .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $message .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
    $message .= $textContent . "\r\n"; // Plain text version
    
    $message .= "--boundary\r\n";
    $message .= "Content-Type: text/html; charset=UTF-8\r\n";
    $message .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
    $message .= $contentWithUnsubscribe . "\r\n"; // HTML version
    
    $message .= "--boundary--";

    // Send the email
    //mail($recipient['email'], $subject, $message, $headers);
    signEmail($recipient['email'], $subject, $message, '/var/www/webrepo/email_signing.key', 'mail.gametank.zone', 'default', $headers);
}

// Respond with a success message
http_response_code(200);
echo json_encode(['status' => 'success', 'message' => 'Emails sent successfully']);
?>

