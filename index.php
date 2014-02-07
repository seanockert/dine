<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

    require('dine/config.php'); 
    require('dine/db.php'); 

    $page = 'index';

    if ($is_cached) set_cache($page, $cachetime);   
    
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