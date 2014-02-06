<?php
    require('dine/db.php'); 

    // Path and name of cached file
    $cachefile = 'cache/menu.html';
    // Check if the cached file is still fresh. If it is, serve it up and exit.
    if (file_exists($cachefile) && time() - $cachetime < filemtime($cachefile) && $is_cached) {
    include($cachefile);
        exit;
    }
    // if there is either no file OR the file to too old, render the page and capture the HTML.
    ob_start();
    
    $page = 'Menu';
    
    $option = $DB->read('options');
    $categories = $DB->read('categories');
    $items = $DB->read('items','item_order');
    $subitems = $DB->read('subitems','title');

    $siteOptions = array();
    foreach ($option as $value) {
        $siteOptions[$value['type']] = $value['content'];
    }    
    
    $catTitle = array();
    foreach ($categories as $cat) {
        array_push($catTitle, $cat['title']);
    }
?>

<?php include('partials/header.php'); ?>

<?php 


    foreach($items as $menuitem) {
      $parent = $menuitem['category'];
      $menuitems[$parent][] = $menuitem;
    }    
    // Re-sort by category
    ksort($menuitems);    
    
    $options = array();
    // Sort $subitems by parent_id and output $options array
    foreach($subitems as $item) {
      $parentID = $item['parent_id'];
      if(!isset($options[$parentID])) {
          $options[$parentID] = array();
      }
      array_push($options[$parentID], $item);
    }   

?>
<div class="container">
  
  <div class="hero clearfix">
    <div class="row">
        <div class="columns large-4">
          <h1><a href="./" title="Return to homepage"><?php echo $siteOptions['name']; ?></a></h1>  
        </div> 
         
        <div class="columns large-3 small-6">
          <?php echo nl2br($siteOptions['hours']); ?>
        </div>          
        
        <div class="columns large-3 small-6">
          <?php echo nl2br($siteOptions['address']); ?> 
        </div>          
        
        <div class="columns large-2">
          <a href="./" class="menu">Home</a> 
        </div>                   
        
    </div>
  </div>
  
   <div class="row">
      	<ul id="menu">
            <?php
              if (count($menuitems) > 0) { 
                $i = 0;
                foreach($menuitems as $key => $category) {
                  echo '<h2>' . $catTitle[$i] . '</h2>';
                      
                  foreach($category as $row) { ?>
                      
                      <li>
                          <h3><?php echo $row['title']; ?> 
                          <strong class="price">
                            <?php echo $currency; echo $row['price']; ?>
                          </strong></h3>
                          <p class="description"><em><?php echo $row['description']; ?></em></p>
                                                     
                            <?php if (isset($options[$row['id']]) && count($options[$row['id']]) > 0) {  ?>
                            <ul class="options">
                              <?php foreach($options[$row['id']] as $option) {  ?>
                              <li><?php echo $option['title']; ?> <span>
                                <?php echo $currency; echo $option['price']; ?>
                              </span></li>      
                              <?php } ?>
                          </ul>
                          <?php } ?>
                      </li>    
                      <?php } ?>
            <?  
              ++$i;
              }    
  
            } else {
              echo '<li><em>Sorry, there is nothing on the menu yet.</em></li>';
            } ?>
      	</ul>
    </div>

<?php include('partials/footer.php'); ?>
