<!DOCTYPE html>
<?php
// block defaults
$title = isset($title)?$title:"Seating";
$header = isset($header)?$header:"<h1>Seating App</h1>";
$breadcrumbs = isset($breadcrumbs)?$breadcrumbs:'<ul><li><a href="/">Home</a></ul>';
$site_nav = isset($site_nav)?$site_nav:"";
$content = isset($content)?$content:"==content==";
$footer = isset($footer)?$footer:"==footer==";
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo HTML::chars($title) ?></title>
<?php 
    echo HTML::style('media/css/960.css');
    echo HTML::style('media/css/main.css');
?>
</head>
<body>
    <div id="header" class="container_12"><?php echo $header ?></div>
    <div id="sub_header" class="container_12">
        <?php echo $breadcrumbs; ?>
        <span id="site_nav"><?php echo $site_nav ?>login/out</span>
    </div>
    <div id="container" class="container_12">
      <?php echo client::messageFetchHtml(); ?>
        <div id="content" class="grid_10">
            <?php echo $content ?>
        </div>
    </div>
    <br class="clear" />
    <div id="footer" class="container_12"><?php echo $footer ?></div>
    <?php echo HTML::script('media/js/jquery-1.4.2.min.js'); ?>
    <?php echo isset($js_extra)?$js_extra:''; ?>
</body>
</html>