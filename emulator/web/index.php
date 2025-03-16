<?php
include '/include/db.php';
$pagetitle = "GameTank Emulator - WASM Edition";
if(isset($_GET['game'])) {
  try {
      $db = get_db("games");
      $sql = 'SELECT * from games where gameID = :id';
      $statement = $db->prepare($sql);
      $statement->execute([
        ":id" => $_GET['game']
      ]);

      if ($statement->rowCount() > 0) {
          if($row = $statement->fetch()) {
              $title = $row['title'];
              $id = $row['gameID'];
              $link = "https://gametank.zone/emulator/web?game=$id";
              $img = "https://gametankgames.nyc3.cdn.digitaloceanspaces.com/games/phpapi/$id/mainimg.png";
              $pagetitle = 'GameTank Emulator - ' . $title;
          }
      }
      http_response_code(200);
  } catch (PDOException $e) {
  }
}

?>

<!doctype html>
<html lang="en-us">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?php
echo "<title>$pagetitle</title>";
readfile("./index.html")
?>