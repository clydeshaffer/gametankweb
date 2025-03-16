<?php

include 'upload.php';
include '../../include/db.php';

session_start();

if(isset($_SESSION["user"])) {
    try {
        $db = get_db("games");
        $sql = 'SELECT * from games where gameID = :id';
        $statement = $db->prepare($sql);
        $statement->execute([
          ":id" => $_POST['id']
        ]);
    
        if ($statement->rowCount() > 0) {
            if($row = $statement->fetch()) {
                if($row['author'] == $_SESSION['user']) {
                    http_response_code(200);
                    $romfileKey = 'games/phpapi/' . $row['gameID'] . '/game.gtr';
                    header('Content-Type: application/json; charset=utf-8');
                    echo json_encode(['status' => 'ok', 'url' => generatePresignedUrl('gametankgames', 'nyc3', $romfileKey)]);
                }
            }
        }
    } catch (PDOException $e) {
    }
} else {
    http_response_code(401);
}


?>