<?php $title = "GameTank"; ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/include/postlist.php'?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/include/head.php'?>
<center>
    <h2>Try these GameTank games on the web emulator!</h2>
</center>
<div class='gallery'>
<?php

include '../include/db.php';

$db = get_db("games");

$sql = 'SELECT* from games where visibility=1';

$statement = $db->prepare($sql);
try {
    $statement->execute();

    if ($statement->rowCount() > 0) {
        while($row = $statement->fetch()) {

            $title = $row['title'];
            $id = $row['gameID'];
            $link = "https://gametank.zone/emulator/web?game=$id";
            $img = "https://gametankgames.nyc3.cdn.digitaloceanspaces.com/games/phpapi/$id/mainimg.png";

            echo "
			<a href='$link'>
			<figure class='postPreviewBox'>
      				<img src='$img'>
      		<figcaption>
        		$title
     		 </figcaption>
    		</figure>
    		</a>
			";
        }
    }
    http_response_code(200);
} catch (PDOException $e) {
    http_response_code(500);
    exit('IDK something went sideways: ' . $e->getMessage());
}
?>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'].'/include/foot.php'?>