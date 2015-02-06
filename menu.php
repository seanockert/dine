<?php
error_reporting(E_ALL);
    require('dine/loader.php');
    $page = 'menu';
    
    // Set caching
    if ($is_cached) $helper->set_cache($page, $cachetime);       
    
    // Grab the data from the database
    $site_options = $helper->site_options($DB->read('options'));
    $categories = $DB->read('categories','order');
    $items = $DB->read('items','item_order');
    $sub_items = $DB->read('subitems','title');

    // Create an array of category titles
    $category_titles = array(''); // category ID starts at 1
    foreach ($categories as $category) { 
        array_push($category_titles, $category->title);
    }
    
    // Sort menu items by category
    $menu_items_by_category = $helper->sort_menu_items($items, 'category');
    ksort($menu_items_by_category); // Re-sort by category

    // Sort sub-items by their parent item
    $sub_items_by_item = $helper->sort_menu_items($sub_items, 'parent_id');
    
?>

<?php include('partials/header.php'); ?>

<div class="container">

  <div class="hero menu-hero clearfix">
    <div class="row">
        <div class="columns large-9">
          <h1><a href="./" title="Return to homepage" data-instant><?php echo $site_options->name; ?></a></h1>  
        </div>

        <div class="columns large-3">
          <a href="./" class="menu" data-instant>Return Home</a>
        </div>

        <div class="clear"></div>
    </div>
  </div>

   <div class="row">
      <div class="columns large-6 medium-8 large-centered medium-centered">

        <h1>Dining Menu</h1>
      	<ul id="menu">
            <?php
            if (count($menu_items_by_category) > 0) {
              foreach($menu_items_by_category as $key => $menu_items) {
                echo '<h2>' . $category_titles[$key] . '</h2>';

                foreach($menu_items as $item) { ?>

                    <li>
                      <h3><?php echo $item->title; ?>
                      <strong class="price right">
                        <?php echo $currency; echo $item->price; ?>
                      </strong></h3>
                      <p class="description"><em><?php echo $item->description; ?></em></p>

                      <?php if (isset($sub_items_by_item[$item->id]) && count($sub_items_by_item[$item->id]) > 0) {  ?>
                      <ul class="options">
                        <?php foreach($sub_items_by_item[$item->id] as $item_option) { ?>
                          <li>
                            <?php echo $item_option->title; ?>
                            <div class="right"><?php echo $currency; echo $item_option->price; ?></div>
                        </li>
                        <?php } ?>
                      </ul>
                      <?php } ?>
                    </li>
                <?php } ?>
                <hr>

              <?php }
            } ?>
      	</ul>
      </div>
    </div>

<?php include('partials/footer.php'); ?>
