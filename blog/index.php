<?php
    $title = "GameTank";
    $page="blog";
?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/include/postlist.php'?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/include/head.php'?>

<h2>Development writeups</h2>
<p>
    While developing the system I would sporadically write about the challenges for each feature and what I learned while working on it. These articles are mostly here as a historical note rather than complete documentation on each system feature.
</p>
<?php postList("posts"); ?>

<?php include $_SERVER['DOCUMENT_ROOT'].'/include/foot.php'?>