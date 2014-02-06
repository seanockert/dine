<?php include('dine/config.php'); /* Load the config file */ 
    // Path and name of cached file
    $cachefile = 'cache/index-'.time().'.html'; //$cachetime
    // Check if the cached file is still fresh. If it is, serve it up and exit.
    if (file_exists($cachefile) && time() - $cachetime < filemtime($cachefile) && $is_cached) {
    include($cachefile);
        exit;
    }
    // if there is either no file OR the file to too old, render the page and capture the HTML.
    ob_start();
?>
<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!-->  <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width,initial-scale=1">

        <title><?php echo $page; ?> - <?php echo $siteOptions['name']; ?></title>
        <meta name="description" content="<?php echo $siteOptions['description']; ?>">

        <link rel="stylesheet" type="text/css" href="css/style.css"></link>
    </head>

    <body>