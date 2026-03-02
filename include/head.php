<!DOCTYPE html>
<html>
<head>
    <title><?php echo $title; ?></title>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
    	$cssfile = '/css/main.css?ver=' . md5_file($_SERVER['DOCUMENT_ROOT'].'/css/main.css');

        $pageclass = "";
        if (isset($page)) {
            if ($page === 'home') {
                $pageclass = "homepage";
            } elseif ($page === 'blog') {
                $pageclass = "bloghome";
            }
        } else {
            $page = "";
        }
    ?>
    <link rel="stylesheet" type="text/css" href="<?php echo $cssfile; ?>"/>
    <link href="https://fonts.cdnfonts.com/css/lato" rel="stylesheet">
    <?php if ($page === "home"): ?>
        <link href="https://fonts.cdnfonts.com/css/manifestly" rel="stylesheet">
        <link href="https://fonts.cdnfonts.com/css/depixel" rel="stylesheet">
    <?php endif; ?>
</head>
<body>
    <div class="pagewrapper">
    <?php include $_SERVER['DOCUMENT_ROOT'].'/include/nav.php'?>
    <main class="<?=$pageclass?>">