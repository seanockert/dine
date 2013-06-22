<?php
    $cachefile = 'cache/menu.html';  // Path and name of cached file
    $cachetime = 3600; // cache time in seconds 3600 = 1 hour
    $is_cached = false; // Set to true to enable page caching in HTML
    
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
    $result = $db->query('SELECT * FROM items ORDER BY item_order');
    $subitems = $db->query('SELECT * FROM subitems ORDER BY title');
        
    $db = NULL;

    foreach($result as $menuitem) {
      $parent = $menuitem['category'];
      if(!$options[$menuitem]) {
          $options[$menuitem] = array();
      }
      $menuitems[$parent][] = $menuitem;
    }    
    // Re-sort by category
    ksort($menuitems);    
    
    // Sort $subitems by parent_id and output $options array
    foreach($subitems as $item) {
      $parent = $item['parent_id'];
      if(!$options[$parent]) {
          $options[$parent] = array();
      }
      $options[$parent][] = $item;
    }   

?>
        <div class="container">
    	   <div class="row">
            	<header>
                    <a href="index.php" class="right button">Home</a>
            		<h1><a href="./" title="Return to homepage"><?php echo $site_title; ?></a></h1>                   
            	</header>
            	<div id="menu">
                  <?php
                    if (count($result) > 0) { 
                      foreach($menuitems as $key => $category) {
                            echo '<h2>' . $categories[$key] . '</h2><ul id="#category-' . $key . '" class="two-cols">';
                            
                        foreach($category as $row) { ?>
                            
                            <li>
                                <h3><?php echo $row['title']; ?> <span class="price"><?php echo $row['price']; ?></span></h3>
                                <p class="description"><em><?php echo $row['description']; ?></em></p>
                               
                                
                                  <?php if (count($options[$row['id']]) > 0) {  ?>
                                  <ul class="options">
                                    <?php foreach($options[$row['id']] as $option) {  ?>
                                    <li><?php echo $option['title']; ?> <span><?php echo $option['price']; ?></span></li>      
                                    <?php } ?>
                                </ul>
                                <?php } ?>
                            </li>    
                            <?php } ?>
                            </ul><div class="clear"></div>
                        <br><hr>
                        
                  <?  }    
                  } else {
                    echo '<li><em>Sorry, there is nothing on the menu yet.</em></li>';
                  } ?>
            	</div>
            	<footer>
                	&copy 2013 <a href="mailto:seanockert@gmail.com">Sean Ockert</a> | <a href="edit/menu.php" title="Edit this page">Edit</a>
            	</footer>
            </div>

<?php include('partials/footer.php'); ?>
