<?php

include '../../include/db.php';

session_start();

if(isset($_SESSION["user"])) {
    try {
        $db = get_db("games");
        $sql = 'UPDATE games set title = :title, description = :description, visibility = :visibility where gameID = :id and author = :author';
        $statement = $db->prepare($sql);
        $statement->execute([
          ":id" => $_POST['id'],
          ":author" => $_SESSION["user"],
          ":title" => $_POST['title'],
          ":description" => $_POST['description'],
          ":visibility" => $_POST['visibility']
        ]);
    
        header("Location: https://gametank.zone/emulator/web/?game=" . $_POST["id"]);
    } catch (PDOException $e) {
    }
} else {
    http_response_code(401);
}

?>