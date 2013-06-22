<?php
if ($_SESSION['user'] = true) {
  error_reporting(~E_NOTICE & ~E_WARNING);

  try
  {   
    $db = new PDO("sqlite:../appdata/$db_name");
    
    $action = $_POST['action'];
    $message = $alertType = '';
    
    /*
      This first thing to do is to setup a database by creating tables in it
    */
    if($action == 'setup')
    {
      //create a table in the database
      $db->exec("CREATE TABLE content (id INTEGER PRIMARY KEY, title TEXT, content TEXT, position TEXT, date_modified TEXT, date_created TEXT)");
      $db->exec("CREATE TABLE items (id INTEGER PRIMARY KEY, title TEXT, description TEXT, price TEXT, category TEXT, item_order INTEGER, date_modified TEXT, date_created TEXT)");
      $db->exec("CREATE TABLE subitems (id INTEGER PRIMARY KEY, parent_id INTEGER, title TEXT, price TEXT, item_order INTEGER, date_modified TEXT, date_created TEXT)");
      $db->exec("CREATE TABLE gallery (id INTEGER PRIMARY KEY, title TEXT, src TEXT, date_modified TEXT, date_created TEXT)");
      $message = "Database setup complete";
      $alertType = "alert-success active";
    }
    
    //Save the content to database
    else if($action == 'flushcache')
    {  
      $files = glob('../cache/*');
      foreach($files as $file){
        if(is_file($file))
          unlink($file);
      }
      ob_flush();
      $message = "Cache cleared. Your content is now be updated on the public site.";
      $alertType = "alert-success success";
    }
      
    //Save the content to database
    else if($action == 'add')
    {
      $title = $_POST['title'];
      $content = trim($_POST['content']);
      $position = $_POST['position'];

      $title = SQLite3::escapeString($title);
      $content = SQLite3::escapeString($content);
             
      $date_modified = time();
      $date_created = time();

      $sql = "INSERT INTO content(title, content, position, date_modified, date_created) VALUES ('$title', '$content', '$position', '$date_modified', '$date_created')";      
      $query = $db->exec($sql);
      
      if($query == 0) {
        $message = "Something went wrong and your item was not saved. Please try again.";
        $alertType = "alert-error active";
      } else {
        $message = "Content saved successfully";
        $alertType = "alert-success success";
      }
    }
   
    //Code to save the data to database
    else if($action == 'update')
    {
      $id = $_POST['id'];
      $title = $_POST['title'];
      $content = $_POST['content'];
      $position = $_POST['position'];
      
      $title = SQLite3::escapeString($title);
      $content = SQLite3::escapeString($content); 
               
      $date_modified = time();  

      $query = $db->exec("UPDATE content SET 'title' = '$title', 'content' = '$content', 'position' = '$position', 'date_modified' = '$date_modified' WHERE id = '$id'");
      
      if($query == 0) {
        $message = "Something went wrong and your content: " . $_POST['title'] . " was not updated. Please try again.";
        $alertType = "alert-error active";
      } else {
        $message = "Content updated successfully";
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
      $query = $db->exec("DELETE FROM content WHERE id = '$id';");
      
      if($query)
      {
        $message = "This content has been deleted";
        $alertType = "alert-success active";
      }
    }
      
    //SELECT query to display existing entries
    $result = $db->query('SELECT * FROM content');
      
    //close the database connection
    $db = NULL;
  }

  catch(PDOException $e)
  {
    print 'Exception : '.$e->getMessage();
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
                    <li><a href="./" class="button active">Edit Content</a></li>
                    <li><a href="./menu.php" class="button">Edit Menu</a></li>   
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

      <h3>Site Content</h3>
      
        <?php if (count($result) > 0) {
          foreach($result as $row) { ?>      
          <div class="content">
            <form method="post" action="">
              <h4><input type="text" name="title" value="<?php echo $row['title']; ?>" placeholder="Title of content"></h4>
              <textarea name="content" placeholder="Start writing here..."><?php echo $row['content']; ?></textarea>
              <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
              <input type="hidden" name="position" value="top">
              <input type="hidden" name="action" value="update">
              <input type="submit" value="Update" class="button green">            
            </form>
            <form method="post" action="" class="delete-content">
              <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
              <input type="hidden" name="action" value="delete" >
              <input type="submit" name="submit" value="Delete" class="delete">
            </form>
          </div>
        <?php } ?>          
        <?php } else {
          echo '<tr><td colspan="7"><em>No menu items yet.</em> <a href="#" data-reveal-id="add-content" class="button green">Add some content</a></td></tr>';
        } ?>
  
        <p><a href="#" data-reveal-id="add-content" class="button green">Add Another Content Section</a></p>
        <br> 

        <div id="add-content" class="reveal-modal">
          <form method="post" action="">
            <h3>Add A Content Section</h3>
            <h4><input type="text" name="title" value="" placeholder="Title of content"></h4>
            <p><textarea name="content" placeholder="Start writing here..."></textarea></p>
            <input type="hidden" name="position" value="top">
            <input type="hidden" name="action" value="add">
            <p><input type="submit" name="submit" value="Add Content Section" class="button green"></p>
          </form>
          <a class="close-reveal-modal">&#215;</a>  
        </div>
        
          <div class="tools">
            <h3>Tools</h3>
            <form method="post" class="left">
              <input type="hidden" name="action" value="flushcache">
              <input type="submit" name="submit" value="Flush Cache" />
            </form>        
            <form method="post" class="left">
              <input type="hidden" name="action" value="setup">
              <input type="submit" name="submit" value="Setup Database" />
            </form>
          </div>
          <div class="clear"></div>
          <footer class="text-center"> 
            <hr>&copy 2013 <a href="http://balsamade.com/dine">Dine</a> by <a href="mailto:seanockert@gmail.com">Sean Ockert</a>
          </footer>           
          
        </div>
    </div>
    
    <script src="../js/jquery.min.js"></script>
    <script src="../js/jquery.reveal.js"></script>
    <script src="../js/plugins.js"></script>
    <script src="../js/edit.js?v=2"></script>    
  </body>
</html>
<?php } else {
header('Location: /login.php');
} ?> 
