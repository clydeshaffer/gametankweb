<?php $title = "GameTank"; ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/include/gamelist.php'?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/include/head.php'?>
<center>
    <h2>Try these GameTank games on the web emulator!</h2>
</center>

<div class="game-gallery">
    <?php gameList("game_entries"); ?>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'].'/include/foot.php'?>