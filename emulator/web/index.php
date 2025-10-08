<!doctype html>
<html lang="en-us">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">


<?php
include '../../include/db.php';
$pagetitle = "GameTank Emulator - WASM Edition";

$editstyle = <<<EOD
<style>
.editonly {
display: none;
}
</style>
EOD;

session_start();

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
              $author = $row['author'];
              $visibility = $row['visibility'];
              $description = $row['description'];

              echo "<script>var GAMEINFO = { title : \"$title\", id : $id, visibility : $visibility, description : \"$description\" }; var USER_CAN_EDIT = true;</script>";

              if(isset($_SESSION["user"]) && ($_SESSION["user"] == $author)) {
                $editstyle = <<<EOD
                <style>
                .editonly {
                display: block;
                }
                </style>
                EOD;
              }
          }
      }
      http_response_code(200);
  } catch (PDOException $e) {
  }
}

echo "<title>$pagetitle</title>";

echo "<meta content=\"$pagetitle\" property=\"og:title\">";
if(isset($img)) {
  echo "<meta content='$img' property='og:image'>";
}
echo "<meta content=\"GameTank Web Emulator\" property=\"og:site_name\">";
if(isset($description)) {
  echo "<meta content=\"$description\" property=\"og:description\">";
}
echo $editstyle;

readfile("./index.html")
?>