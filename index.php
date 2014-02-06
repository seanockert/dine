<?php
    require('dine/db.php'); 

    // Path and name of cached file
    $cachefile = 'cache/index.html';
    // Check if the cached file is still fresh. If it is, serve it up and exit.
    if (file_exists($cachefile) && time() - $cachetime < filemtime($cachefile) && $is_cached) {
    include($cachefile);
        exit;
    }
    // if there is either no file OR the file to too old, render the page and capture the HTML.
    ob_start();
    
    $page = 'Home';
    
    $options = $DB->read('options');
    $contents = $DB->read('contents');
    $images = $DB->read('photos');

    $siteOptions = array();
    foreach ($options as $value) {
        $siteOptions[$value['type']] = $value['content'];
    }
?>

<?php include('partials/header.php'); ?>

<?php include('partials/page.php'); ?>
        
<?php include('partials/footer.php'); ?>