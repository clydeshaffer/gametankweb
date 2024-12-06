<?php
    function makeDescription($game) {
	if (!array_key_exists('desc', $game))
	   return '';

	return "<div class='desc'>" . $game['desc'] . "</div>";
    }

    function makeAuthor($game) {
	if (!array_key_exists('author_name', $game))
	   return '';

	if (!array_key_exists('author_link', $game))
	    return "<div class='author'>By " . $game['author_name'] . "</div>";

	return "<div class='author'>By <a href='" . $game['author_link'] . "'>" . $game['author_name'] . "</a></div>";
    }

    function makeGameBox($game) {
	$thumb = $game['thumb'] ?? "/img/whomst.jpg";
	$title = $game['title'];
	$link = $game['link'];
	$desc = makeDescription($game);
	$author = makeAuthor($game);

	echo "
    <div class='game'>
	<a href='$link'>
	    <img src='$thumb' />
	</a>
	<div class='details'>
	    <div class='title'><a href='$link'>
		$title
	    </a></div>
	    $desc
	    $author
	</div>
    </div>
";
    }


    function gamelist($dir) {
	$path = "../games/games.json";
	$f = fopen($path, 'r');
	$json = json_decode(fread($f, filesize($path)), true);

	$games = $json['games'];

	echo "<div class='gallery'>";
	foreach ($games as $game) {
	    makeGameBox($game);
	}
	echo "</div>";
    }
?>
