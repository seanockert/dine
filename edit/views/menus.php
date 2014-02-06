<?php
if ($_SESSION['user'] == true) {

    //SELECT query to display existing entries
    $categories = $DB->read('categories', 'category_order'); 
    $items = $DB->read('items', 'item_order'); 
    $subitems = $DB->read('subitems', 'title'); 

    $options = array();

    // Create an array for each category of items
    foreach($items as $item) {
      $parent = $item['category'];
      //if(!$options[$item]) {
      //    $options[$item] = array();
      //}
      $menuitems[$parent][] = $item;

    }
    // Re-sort by category
    ksort($menuitems); 

    // Sort $subitems by parent_id and output $options array
    foreach($subitems as $subitem) {
      $parent = $subitem['parent_id'];
      if(!$options[$parent]) {
          $options[$parent] = array();
      }
      $options[$parent][] = $subitem;
    } 

    // Add categories to an array so we can reuse it
    $categorySelector = '';
    $i = 1;
    foreach($categories as $category) {
      $categorySelector .= '<option value="' . $category['id'] . '">' . $category['title'] . '</option>';
      $categoryList[$i] = $category;
      ++$i;
    }
?>
  <body id="edit">

    <div id="sidebar"> 
      <h2><a class="brand" href="../" title="Return to site"><?php echo $siteTitle['content']; ?></a></h2>
      <nav>
        <ul>
            <li><a href="./">Content</a></li>
            <li><a href="./menus.php" class="active">Menus</a></li>   
            <li><a href="./photos.php">Photos</a></li>   
            <li><a href="./options.php">Options</a></li>   
            <li><a href="controllers/login.php?action=logout" class="logout">Log Out</a></li>   
        </ul>
      </nav>   
    </div> 

    <div id="content">
        
        <div id="header">
            <h1>Edit Menus</h1>
            <div class="clear"></div> 
        </div>

      <div class="alert <?php echo $_SESSION['alertType']; ?>"><?php echo $_SESSION['message']; ?></div>

      <h3>Categories</h3>
      <ul class="nolist">
      <?php 
        foreach($categoryList as $category) { ?>
          <li data-id="<?php echo $category['id']; ?>"><?php echo $category['title']; ?> 
            <form method="post" action="controllers/categories.php" class="delete-category">
              <input type="hidden" name="id" value="<?php echo $category['id']; ?>" >
              <input type="hidden" name="action" value="delete" >
              <input type="submit" name="submit" value="Delete" class="delete">
            </form>
          </li>
             
      <?php } ?>
      </ul>
     <div class="clear"></div>
     <p><a href="#" data-reveal-id="add-category" data-parent="<?php echo $row['id']; ?>" class="add-category button green">Add Category</a></p>
     
     <hr>       

    <h3>Menu Items</h3>
    <?php if (count($categories) > 0) { ?>      
      
      <table class="item-list">
        <thead>
        <tr>
          <th>&nbsp;</th>
          <th>Title</th>
          <th class="description">Description</th>
          <th class="price">Price</th>
          <th class="menu">Menu</th>
          <th colspan="3">Actions</th>
        </tr>
        </thead>
        
      <?php
          if (count($menuitems) > 0) {
            
           foreach($menuitems as $key => $category) { ?>
              <thead class="subheader">
              <tr>
                <th colspan="9"><?php echo $categoryList[$key]['title']; ?></th>
              </tr>
              </thead>
              <tbody class="sliplist">
              <?php foreach($category as $row) { ?>         
            
              <?php printf('<tr class="%s" id="%s" title="Last modified: %s" data-order="%s">', ($row['id'] % 2) ? 'odd' : 'even', $row['id'], date('l jS \of F Y h:i:s A', $row['date_modified']),  $row['item_order']); ?>

              <form class="edit-item" method="post" action="controllers/menus.php">
                <td class="move-handle"><input type="hidden" name="item_order" maxlength="2" class="item-order" value="<?php echo $row['item_order']; ?>"></td>
                <td><input type="text" name="title" class="title" value="<?php echo $row['title']; ?>" placeholder="<?php echo $row['title']; ?>"></td>
                <td><input type="text" name="description" value="<?php echo $row['description']; ?>" placeholder="<?php echo $row['description']; ?>"></td>
                <td><input type="text" name="price" value="<?php echo $row['price']; ?>" placeholder="<?php echo $row['price']; ?>"></td>
                <td><select name="category" id="category">
                  <?php foreach ($categoryList as $category) {
                    if ($catID == $row['category']) {
                      echo '<option value="' . $category['id'] . '" selected = "selected">' . $category['title'] . '</option>';
                    } else {
                      echo '<option value="' . $category['id'] . '">' . $category['title'] . '</option>';
                    }
                  } ?>
                </select>
                </td>
                <td class="actions">
                  <input type="hidden" name="id" value="<?php echo $row['id']; ?>">            
                  <input type="hidden" name="action" value="update">
                  <input type="submit" value="Update" class="button green">            
                </td>
              </form>
              <td class="actions add-option"><a href="#" data-reveal-id="add-subitem" data-parent="<?php echo $row['id']; ?>" class="add-subitem">Add Option</a></td>
              <td class="actions">
              <form method="post" action="controllers/menus.php" class="delete-item">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <input type="hidden" name="action" value="delete" >
                <input type="submit" name="submit" value="Delete" class="delete">
              </form>
              </td>
              <?php if ($options) { 
                foreach($options[$row['id']] as $option) {  ?>
                <?php printf('<tr class="options %s" data-parent="%s">', ($row['id'] % 2) ? 'odd' : 'even', $row['id']); ?>
                  <td></td>
                  <td></td>
                  <td><?php echo $option['title']; ?></td>   
                  <td><?php echo $option['price']; ?></td>
                  <td colspan="2"></td>
                  <td colspan="3" class="actions">
                    <form method="post" action="controllers/menus.php" class="delete-option">
                    <input type="hidden" name="id" value="<?php echo $option['id']; ?>">
                    <input type="hidden" name="action" value="delete-option" >
                    <input type="submit" name="submit" value="Remove option" class="delete">
                    </form>
                  </td>
                </tr>    
              <?php } ?>
            </tr>

            <?php } ?>          
            <?php } ?>          
          <?php } ?>          
        <?php } else {
          echo '<tr><td colspan="8"><em>No menu items yet.</em> <a href="#" data-reveal-id="add-item">Add one</a></td></tr>';
          } 
        ?>

        </tbody>
      </table>
      <p><a href="#" data-reveal-id="add-item" class="button green">Add New Item</a></p>
      <?php } else {
        echo '<em>Add a category first</em>';
      } ?> 

        <div id="add-item" class="reveal-modal">
        <form method="post" action="controllers/menus.php">
          <h3>Add a New Menu Item</h3>
   
          <p>Which menu are you adding to?
            <select name="category" id="category">
                <?php echo $categorySelector; ?> 
            </select>
          </p>       
          <p><label>Title</label> <input type="text" name="title" placeholder="Name of dish"></p>
          <p><label>Description</label> <input type="text" name="description" class="long" placeholder="Brief description"></p>
          <p><label>Price</label> <input type="text" name="price" class="price"></p>
          <input type="hidden" name="action" value="add">
          <p><br><input type="submit" name="submit" value="Add Item" class="button green"></p>
        </form>
        <a class="close-reveal-modal">&#215;</a>   
        </div> <!-- End modal -->
        
        <div id="add-subitem" class="reveal-modal">
        <form method="post" action="controllers/menus.php">
          <h3>Add an option to <span></span></h3>
          <p><label>Title</label> <input type="text" name="title" placeholder="Name of this option"></p>
          <p><label>Price</label> <input type="text" name="price" class="price"></p>
          <input type="hidden" name="parent_id" id="parent_id" value="0">
          <input type="hidden" name="action" value="add-option">
          <p><br><input type="submit" name="submit" value="Add Option" class="button green"></p>
        </form>
        <a class="close-reveal-modal">&#215;</a>   
        </div> <!-- End modal -->        
        
        <div id="add-category" class="reveal-modal">
        <form method="post" action="controllers/categories.php">
          <h3>Add a new category <span></span></h3>
          <p><label>Title</label> <input type="text" name="title" placeholder="Name of this category"></p>
          <input type="hidden" name="action" value="add">
          <p><br><input type="submit" name="submit" value="Add Category" class="button green"></p>
        </form>
        <a class="close-reveal-modal">&#215;</a>   
        </div> <!-- End modal -->
        
    </div>

  <?php include('partials/footer.php'); ?>

<?php } else {
  header('Location: /login.php');
} ?> 
