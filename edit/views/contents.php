<?php
  if ($_SESSION['user'] == true) 
  {
     $contents = $DB->read('contents'); 
?>
  
  <body id="edit">

    <div id="sidebar"> 
      <h2><a class="brand" href="../" title="Return to site"><?php echo $siteTitle['content']; ?></a></h2>
      <nav>
        <ul>
            <li><a href="./" class="active">Content</a></li>
            <li><a href="./menus.php">Menus</a></li>   
            <li><a href="./photos.php">Photos</a></li>   
            <li><a href="./options.php">Options</a></li>   
            <li><a href="controllers/login.php?action=logout" class="logout">Log Out</a></li>   
        </ul>
      </nav>   
    </div> 

    <div id="content">
        
        <div id="header">
            <h1>Edit Content</h1>
            <div class="clear"></div> 
        </div>

        <div class="alert <?php echo $_SESSION['alertType']; ?>"><?php echo $_SESSION['message']; ?></div>

        <?php if (count($contents) > 0) {
          foreach($contents as $row) { ?>      
          <div class="content">
            <form method="post" action="controllers/contents.php">
              <h4><input type="text" name="title" value="<?php echo $row['title']; ?>" placeholder="Title of content"></h4>
              <textarea name="content" placeholder="Start writing here..."><?php echo $row['content']; ?></textarea>
              <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
              <input type="hidden" name="position" value="top">
              <input type="hidden" name="action" value="update">
              <p><br><input type="submit" value="Update" class="button green"></p>            
            </form>
            <form method="post" action="controllers/contents.php" class="delete-content">
              <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
              <input type="hidden" name="action" value="delete" >
              <input type="submit" name="submit" value="Delete" class="delete">
            </form>
          </div>
        <?php } ?>          
        <?php } else {
          echo '<tr><td colspan="7"><em>No content yet.</em> <a href="#" data-reveal-id="add-content" class="button green">Add some content</a></td></tr>';
        } ?>
        <hr>
        <p><br><a href="#" data-reveal-id="add-content" class="button green">Add Content Section</a></p>
        <br> 

        <div id="add-content" class="reveal-modal">
          <form method="post" action="controllers/contents.php">
            <h3>Add A Content Section</h3>
            <h4><input type="text" name="title" value="" placeholder="Title of content"></h4>
            <p><textarea name="content" placeholder="Start writing here..."></textarea></p>
            <input type="hidden" name="position" value="top">
            <input type="hidden" name="action" value="add">
            <p><br><input type="submit" name="submit" value="Add Content Section" class="button green"></p>
          </form>
          <a class="close-reveal-modal">&#215;</a>  
        </div>
          

    </div>

  <?php include('partials/footer.php'); ?>

<?php 
} 
else 
{
  header('Location: /login.php');
}
