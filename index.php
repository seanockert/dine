<?php
    require('dine/loader.php'); 

    $page = 'index';

    if ($is_cached) $helper->set_cache($page, $cachetime);   
    
    $site_options = $helper->site_options($DB->read('options'));
    $contents = $DB->read('contents');
    $images = $DB->read('photos');

?>

<?php include('partials/header.php'); ?>

<?php include('partials/page.php'); ?>
        
<?php include('partials/footer.php'); ?>