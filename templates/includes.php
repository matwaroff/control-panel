<?php
    $filename = basename($_SERVER['PHP_SELF']);
    $page = $data->getPage($filename);
    //$settings = $data->getSettings();
    $title = $page['title'];
    $sitetitle = $data->getSetting('siteTitle');
?>
<title><?= $title; ?> - <?= $sitetitle; ?></title>
<link href="/stylesheets/styles.css" rel="stylesheet" type="text/css"/>
<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
<script
    src="https://code.jquery.com/jquery-3.2.1.min.js"
    integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
    crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/javascripts/custom.js" type="text/javascript"></script>
