<?php
if ($_SESSION['user'] = true) {
  error_reporting(~E_NOTICE & ~E_WARNING);

  try
  {   
    /*
      open the database - if database exists, then opens the existing one, else opens a new one.
    */
    $db = new PDO("sqlite:../appdata/$db_name");
    
    $action = $_POST['action'];
    $message = $alertType = '';
    
    //Save the item to database
    if($action == 'add')
    {

      $title = $_POST['title'];
      $description = $_POST['description'];
      $price = $_POST['price'];
      $category = $_POST['category'];
      $item_order = '0';
      
      $title = SQLite3::escapeString($title);
      $description = SQLite3::escapeString($description);
      
      $date_modified = time();
      $date_created = time();

      /*
        INSERT INTO the database
        The exec function returns the number of rows effected
      */
      $query = $db->exec("INSERT INTO items(title, description, price, category, item_order, date_modified, date_created) VALUES ('$title', '$description', '$price', '$category', '$item_order', '$date_modified', '$date_created');");
      
      if($query == 0) {
        $message = "Something went wrong and your item was not added. Please try again.";
        $alertType = "alert-error active";
      } else {
        $message = $title . " added to menu";
        $alertType = "alert-success success";
      }
    }
    
    else if($action == 'update')
    {
      $id = $_POST['id'];
      $title = $_POST['title'];
      $description = $_POST['description'];
      $price = $_POST['price'];
      $category = $_POST['category'];
      $item_order = $_POST['item_order'];
      if ($item_order == '') { $item_order = 0;}
      
      $title = SQLite3::escapeString($title);
      $description = SQLite3::escapeString($description);     
      
      $date_modified = time();      
      
      $query = $db->exec("UPDATE items SET 'title' = '$title', 'description' = '$description', 'price' = '$price', 'category' = '$category', 'item_order' = $item_order WHERE id = '$id';");
      
      if($query == 0) {
        $message = "Something went wrong and your item was not updated. Please try again.";
        $alertType = "alert-error active";
      } else {
        $message = $title . " item updated";
        $alertType = "alert-success active";
      }

    } 
    
     else if($action == 'order')
    {
      $id = $_POST['id'];
      $item_order = $_POST['item_order'];

      $query = $db->exec("UPDATE items SET 'item_order' = $item_order WHERE id = '$id';");
      
      if($query == 0) {
        $message = "Something went wrong and your item's order was not updated. Please try again.";
        $alertType = "alert-error active";
      } else {
        $message = "Item moved";
        $alertType = "alert-success active";
      }   
    }  
      
    /*
      Code to delete an id
    */
    else if($action == 'delete')
    {
      /*
        Delete a particular id
      */
      $id = $_POST['id'];
      $query = $db->exec("DELETE FROM items WHERE id = '$id';");
      
      if($query)
      {
        $message = "Item removed from menu";
        $alertType = "alert-success active";
      }
    }
 
     else if($action == 'add-option')
    {

      $parent_id = $_POST['parent_id'];
      $title = $_POST['title'];
      $price = $_POST['price'];
      $item_order = '0';
      
      $date_modified = time();
      $date_created = time();

      $query = $db->exec("INSERT INTO subitems(parent_id, title, price, item_order, date_modified, date_created) VALUES ('$parent_id', '$title', '$price', '$item_order', '$date_modified', '$date_created');");
      
      if($query == 0) {
        $message = "Something went wrong and your option was not saved. Please try again.";
        $alertType = "alert-error active";
      } else {
        $message = $title . " option added";
        $alertType = "alert-success success";
      }
    }
    
    else if($action == 'delete-option')
    {
      $id = $_POST['id'];
      $query = $db->exec("DELETE FROM subitems WHERE id = '$id';");
      
      if($query)
      {
        $message = "Option removed from menu";
        $alertType = "alert-success active";
      }
    }
      
    //SELECT query to display existing entries
    $result = $db->query('SELECT * FROM items ORDER BY item_order');
    $subitems = $db->query('SELECT * FROM subitems ORDER BY title');
      
    //close the database connection
    $db = NULL;
  }

  catch(PDOException $e)
  {
    print 'Exception : '.$e->getMessage();
  }

    // Create an array for each category of items
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
  <body id="edit">
    <!-- Navigation -->

    <div class="row" id="header">
        <div class="large-12 columns">
          <h1>
            Editing: <a class="brand" href="../"><?php echo $site_title; ?></a>
          </h1>
          
          <div class="right box" id="logout-container">
              <a href="../">View Site</a>
              <a href="?action=logout">Logout</a>
          </div>    
          <div class="clear"></div>              
          <nav>
          <ul>
              <li><a href="./" class="button">Edit Content</a></li>
              <li><a href="./menu.php" class="button active">Edit Menu</a></li>   
              <li><a href="./gallery.php" class="button">Edit Gallery</a></li>   
          </ul>
          </nav>
        </div>
        <hr>
    </div>
    <!-- End Navigation -->    
            
    <div class="container">
      <div class="row">
      <div class="alert <?php echo $alertType; ?>"><?php echo $message; ?></div>

      <h3>Menu Items</h3>
      <!--<input type="search" id="search" value="" placeholder="Type to search">-->
      <table id="item-list" class="item-list">
        <thead>
        <tr>
          <th>&nbsp;</th>
          <th>Title</th>
          <th class="description">Description</th>
          <th class="price">Price</th>
          <th class="menu">Menu</th>
          <!--<th class="order">Order</th>-->
          <th colspan="3">Actions</th>
        </tr>
        </thead>
        
      <?php
        if (count($result) > 0) {
         foreach($menuitems as $key => $category) { ?>
             <thead class="subheader">
               <tr id="category-<?php echo $key; ?>">
                 <th colspan="9"><?php echo $categories[$key]; ?></th>
               </tr>
             </thead>
             <tbody>
              <?php foreach($category as $row) { ?>         
          
            <?php printf('<tr class="%s" id="%s" title="Last modified: %s" data-order="%s">', ($row['id'] % 2) ? 'odd' : 'even', 'item-'.$row['id'], date('l jS \of F Y h:i:s A', $row['date_modified']),  $row['item_order']); ?>

            <form class="edit-item" method="post" action="#item-<?php echo $row['id']; ?>">
            <td class="drag-handle2"><input type="text" name="item_order" maxlength="2" class="item-order" value="<?php echo $row['item_order']; ?>"></td>
            <td><input type="text" name="title" class="title" value="<?php echo $row['title']; ?>" placeholder="<?php echo $row['title']; ?>"></td>
            <td><input type="text" name="description" value="<?php echo $row['description']; ?>" placeholder="<?php if ($row['description'] != '') { echo $row['description'];} else { echo 'No description';} ?>"></td>
            <td><input type="text" name="price" value="<?php echo $row['price']; ?>" placeholder="<?php echo $row['price']; ?>"></td>
            <td><select name="category" id="category">
              <?php foreach ($categories as $catID => $category) {
                if ($catID == $row['category']) {
                  echo '<option value="' . $catID . '" selected = "selected">' . $category . '</option>';
                } else {
                  echo '<option value="' . $catID . '">' . $category . '</option>';
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
            <form method="post" action="#item-<?php echo $row['id']; ?>" class="delete-item">
              <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
              <input type="hidden" name="action" value="delete" >
              <input type="submit" name="submit" value="Delete" class="delete">
            </form>
            </td>
            <?php foreach($options[$row['id']] as $option) {  ?>
              <?php printf('<tr class="options %s" data-parent="%s">', ($row['id'] % 2) ? 'odd' : 'even', $row['id']); ?>
                <td></td>
                <td></td>
                <td><?php echo $option['title']; ?></td>   
                <td><?php echo $option['price']; ?></td>
                <td colspan="2"></td>
                <td colspan="3" class="actions">
                  <form method="post" action="#item-<?php echo $row['id']; ?>" class="delete-option">
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
      <?php } else {
        echo '<tr><td colspan="7"><em>No menu items yet.</em> <a href="#" data-reveal-id="add-item" class="button green">Add one</a></td></tr>';
      } ?>

        </tbody>
      </table>
      <hr>
      <p><a href="#" data-reveal-id="add-item" class="button green">Add Another Item</a></p>
      <br>  
      
        <div id="add-item" class="reveal-modal">
        <form method="post" action="">
          <h3>Add a New Menu Item</h3>
   
          <p>Which menu are you adding to?
            <select name="category" id="category">
                <?php foreach ($categories as $catID => $category) {
                    echo '<option value="' . $catID . '">' . $category . '</option>';
                } ?>
            </select>
          </p>       
          <p><label>Title</label> <input type="text" name="title" placeholder="Name of dish"></p>
          <p><label>Description</label> <input type="text" name="description" class="long" placeholder="Brief description"></p>
          <p><label>Price</label> <input type="text" name="price" class="price"></p>
          <input type="hidden" name="action" value="add">
          <p><input type="submit" name="submit" value="Add Item" class="button green"></p>
        </form>
        <a class="close-reveal-modal">&#215;</a>   
        </div> <!-- End modal -->
        
        <div id="add-subitem" class="reveal-modal">
        <form method="post" action="">
          <h3>Add an option to <span></span></h3>
          <p><label>Title</label> <input type="text" name="title" placeholder="Name of this option"></p>
          <p><label>Price</label> <input type="text" name="price" class="price"></p>
          <input type="hidden" name="parent_id" id="parent_id" value="0">
          <input type="hidden" name="action" value="add-option">
          <p><input type="submit" name="submit" value="Add Option" class="button green"></p>
        </form>
        <a class="close-reveal-modal">&#215;</a>   
        </div> <!-- End modal -->
   
          <footer class="text-center"> 
            <hr>&copy 2013 <a href="http://balsamade.com/dine">Dine</a> by <a href="mailto:seanockert@gmail.com">Sean Ockert</a>
          </footer>   
        
      </div>
    </div>

    <script src="../js/jquery.min.js"></script>
    <script src="../js/jquery.reveal.js"></script>    
    <script src="../js/plugins.js"></script>
    <script src="../js/edit.js"></script>    
    <script>
      $(document).ready(function(){      
        $('.sortable').tableDnD({
            onDragClass: "dragging",
            onDrop: function(table, row) {
                console.log('Dropped');                   
            } 
        });
      });
    
    </script>    
  </body>
</html>
<?php } else {
header('Location: /login.php');
} ?> 
