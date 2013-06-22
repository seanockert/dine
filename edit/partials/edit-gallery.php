
<?php
if ($_SESSION['user'] = true) {
  error_reporting(~E_NOTICE & ~E_WARNING);

  try
  {   
    $db = new PDO("sqlite:../appdata/$db_name");
    
    $action = $_POST['action'];
    $message = $alertType = '';
    
    //Code to save the data to database
    if($action == 'add')
    {
      $src = $_FILES["imgfile"]["name"]; 
      
      $upload = $uploadpath.basename($_FILES["imgfile"]["name"]);
      if (!move_uploaded_file($_FILES["imgfile"]["tmp_name"], $upload)) {
        die("There was an error uploading the file, please try again!");
      }    
      $image_name = $upload.$src;
      list($width,$height) = getimagesize($image_name);
      //$new_image_name = $uploadpath.$_FILES["imgfile"]["name"];
      
      /*
      if ($width > $height) {
        $ratio = (250/$width);
        $new_width = round($width*$ratio);
        $new_height = round($height*$ratio);
      } else {
        $ratio = (250/$height);
        $new_width = round($width*$ratio);
        $new_height = round($height*$ratio);
      }
      
      $image_p = imagecreatetruecolor($new_width,$new_height);
      $img_ext = $_FILES['imgfile']['type'];
      
      if (img_ext == "image/jpg" || img_ext == "image/jpeg") {
        $image = imagecreatefromjpg($image_name);
      } else if ($img_ext == "image/png") {
        $image = imagecreatefrompng($image_name);
      } else if ($img_ext == "image/gif") {
        $image = imagecreatefromgif($image_name);
      } else {
        //die('Not a valid image');
      }

      imagecopyresampled($image_p,$image,0,0,0,0,$new_wi dth,$new_height,$width,$height);
      imagejpeg($image_p,$src,100);
      */
      
      $title = $_POST['title'];
      
      $date_modified = time();
      $date_created = time();
      $query = $db->exec("INSERT INTO gallery(title, src, date_modified, date_created) VALUES ('$title', '$src', '$date_modified', '$date_created');");
      
      $message = "The image " .  $src . " was uploaded successfully";
      $alertType = "alert-success active";
    }
    
    /*
      Code to delete an image by id
    */
    else if($action == 'delete')
    {
      $id = $_POST['id'];
      
      // Remove the image
      unlink($uploadpath . $_POST['src']);
      
      $query = $db->exec("DELETE FROM gallery WHERE id = '$id';");
      
      if($query)
      {
        $message = "The image " . $_POST['src'] . " has been deleted";
        $alertType = "alert-success active";
      }     
    }
      
    //SELECT query to display existing images
    $result = $db->query('SELECT * FROM gallery');

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
                    <li><a href="./" class="button">Edit Content</a></li>
                    <li><a href="./menu.php" class="button">Edit Menu</a></li>   
                    <li><a href="./menu.php" class="button active">Edit Gallery</a></li>   
                </ul>
                </nav>
        </div>
        <hr>
    </div>
    <!-- End Navigation -->    
            
    <div class="container">
      <div class="row">
      <div class="alert <?php echo $alertType; ?>"><?php echo $message; ?></div>

      <h3>Gallery Images</h3>
      
        <?php if (count($result) > 0) {
          foreach($result as $row) { ?>      
          <div class="content">

            <form method="post" action="" class="delete-image">
              <div class="img left"><img src="../img/uploads/<?php echo $row['src']; ?>" width="300"></div>                
              <h3><?php echo $row['title']; ?></h3>  
              <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
              <input type="hidden" name="src" value="<?php echo $row['src']; ?>">
              <input type="hidden" name="action" value="delete" >
              <p><input type="submit" name="submit" value="Delete" class="button"></p>
            </form>
            <div class="clear"></div>
          </div>
        <?php } ?>          
        <?php } else {
          echo '<tr><td colspan="7"><em>No menu images yet.</em> <a href="#" data-reveal-id="add-image" class="button green">Add one</a></td></tr>';
        } ?>
        <div class="clear"></div>
        <p><a href="#" data-reveal-id="add-image" class="button green">Upload a New Image</a></p>
        <br> 

        <div id="add-image" class="reveal-modal">
            <form method="post" enctype="multipart/form-data">
              <h3>Upload a New Image</h3>
              <p><label>Select a image to upload</label> 
                <input type="file" name="imgfile">
              </p>              
              <p><label>Give it a title</label><input type="title" name="title" placeholder="Slide 1"></p>

              <input type="hidden" name="action" value="add">
              <input type="submit" name="submit" class="button green" value="Add Image">
            </form>
            <a class="close-reveal-modal">&#215;</a>  
        </div>
        <div class="clear"></div>
        <footer class="text-center"> 
          <hr>&copy 2013 <a href="http://balsamade.com/dine">Dine</a> by <a href="mailto:seanockert@gmail.com">Sean Ockert</a>
        </footer> 
        </div>  
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
