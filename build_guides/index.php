<?php $title = "GameTank"; ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/include/postlist.php'?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/include/head.php'?>
<center>
        <h2>Build Guides</h2>
    </center>
    <p>
        Here are some guides on building the GameTank console and related devices!
    </p>

    <div class="gallery" style="margin-top:10%">
<h2>Main Console</h2>
<?php postList("console"); ?>
    </div>

<div class="gallery" style="margin-top:10%">
<h2>Peripherals</h2>
<?php postList("posts"); ?>
    </div>

<?php include $_SERVER['DOCUMENT_ROOT'].'/include/foot.php'?>