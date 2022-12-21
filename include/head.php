<head>
    <title><?php echo $title; ?></title>
    <?php
    	$cssfile = '/css/main.css?ver=' . md5_file($_SERVER['DOCUMENT_ROOT'].'/css/clyde.css');
    ?>
    <link rel="stylesheet" type="text/css" href="<?php echo $cssfile; ?>"/>
</head>
<body>
    <?php include $_SERVER['DOCUMENT_ROOT'].'/include/nav.php'?>
    <div class="main">