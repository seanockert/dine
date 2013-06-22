<?php
    $cachefile = 'cache/index.html';  // Path and name of cached file
    $cachetime = 3600; // cache time in seconds 3600 = 1 hour
    $is_cached = true; // Set to true to enable page caching in HTML
    
    // Check if the cached file is still fresh. If it is, serve it up and exit.
    if (file_exists($cachefile) && time() - $cachetime < filemtime($cachefile) && $is_cached) {
      include($cachefile);
      exit;
    }
    // if there is either no file OR the file to too old, render the page and capture the HTML.
    ob_start();
?>

<?php include('partials/header.php'); ?>

<?php 
    $db = new PDO("sqlite:appdata/$db_name"); 
    $contents = $db->query('SELECT * FROM content ORDER BY id');
    $images = $db->query('SELECT * FROM gallery ORDER BY id');
    $db = NULL;
?>

        <div class="container">
           <div class="row">
                <header>
                    <a href="menu.php" class="right button">Menu</a>                    
                    <h1><a href="./" title="Return to homepage"><?php echo $site_title; ?></a></h1>
                </header>
                  <?php if (count($contents) > 0) {  
                    foreach($contents as $content) { ?>
                    <div class="content">
                        <h3><?php echo $content['title']; ?></h3>
                        <p><?php echo nl2br($content['content']); ?></p>
                    </div>    
                    <?php } ?>          
                  <?php } else {
                    echo '<li><em>Coming soon.</em></li>';
                  } ?>
                  
                  <?php if (count($images) > 0) {  
                    foreach($images as $image) { ?>
                    <div class="image">
                        <img src="img/uploads/<?php echo $image['src']; ?>" title="<?php echo $image['title']; ?>">
                    </div>    
                    <?php } ?>          
                  <?php } else {
                    echo '<li><em>Coming soon.</em></li>';
                  } ?>  
                  
                <div class="clear"></div>
                <footer>                    
                    &copy 2013 <a href="mailto:seanockert@gmail.com">Sean Ockert</a> | <a href="edit/" title="Edit this page">Edit</a>
                </footer>
            </div>
        </div>
        
<?php include('partials/footer.php'); ?>