<!DOCTYPE html>
<?php
// Value Defaults
$title = isset($title)?$title:"Simple Placement";
$breadcrumbs = isset($breadcrumbs)?$breadcrumbs:array(array('home'));
// Block defaults
$header = isset($header)?$header:View::factory('admin/pages/header_default');
$right_header = isset($right_header)?$right_header:"login/out";
$content = isset($content)?$content:View::factory('admin/pages/content_default');
$footer = isset($footer)?$footer:View::factory('admin/pages/footer_default');
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
        <ul class="breadcrumb">
        <?php while ($crumb = array_shift($breadcrumbs)) { ?>
            <li><?php echo isset($crumb[0]) ? $crumb[0] : HTML::anchor(current($crumb), key($crumb)) ?></li>
        <?php } ?>
        </ul>
        <span id="site_nav"><?php echo $right_header ?></span>
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
    <div id="kohana-profiler"><?php echo View::factory('profiler/stats'); ?></div>
</body>
</html>