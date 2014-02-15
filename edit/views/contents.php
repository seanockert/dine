<?php

  if ($_SESSION['user'] == true) 
  {
     $contents = $DB->read('contents'); 
?>
  
  <body id="edit">
    
        <?php 
          $active = 'content';
          include('partials/nav.php'); 
        ?>

    <div id="content">
        
        <div id="header">
            <h1>Edit Content</h1>
            <div class="clear"></div> 
            <a href="#" data-reveal-id="markdown-tips">Tips for formatting your content</a><br><br>
        </div>

        <div class="alert <?php echo $_SESSION['alertType']; ?>"><?php echo $_SESSION['message']; ?></div>

        <?php if (count($contents) > 0) {
          foreach($contents as $row) { ?>      
          <div class="content">
            <form method="post" action="controllers/contents.php">
              <h4><input type="text" name="title" value="<?php echo $row->title; ?>" placeholder="Give this section a name"> <a href="#" class="grey preview-button">Preview</a></h4>
              <textarea name="content" id="editor" placeholder="Add content here..."><?php echo $row->markdown; ?></textarea>
              <div class="preview"></div>
              <input type="hidden" name="id" value="<?php echo $row->id; ?>">
              <input type="hidden" name="position" value="top">
              <input type="hidden" name="action" value="update">
              <p><br><input type="submit" value="Update" class="button blue"></p>            
            </form>
            <form method="post" action="controllers/contents.php" class="delete-content">
              <input type="hidden" name="id" value="<?php echo $row->id; ?>">
              <input type="hidden" name="action" value="delete" >
              <input type="submit" name="submit" value="Delete" class="delete">
            </form>
            <hr>
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
            <h4><input type="text" name="title" value="" placeholder="Give this section a name"></h4>
            <p><textarea name="content" placeholder="Add content here..."></textarea></p>
            <input type="hidden" name="position" value="top">
            <input type="hidden" name="action" value="add">
            <p><br><input type="submit" name="submit" value="Add Content Section" class="button green"></p>
          </form>
          <a class="close-reveal-modal">&#215;</a>  
        </div>        
        
        <div id="markdown-tips" class="reveal-modal">
          <h3>How To Format Your Content</h3>
          <hr>
          <strong>#</strong>This is a heading = <h2 style="display: inline; margin: 0;">This is a heading</h2><br><br>
          <strong>##</strong>A smaller heading = <h3 style="display: inline; margin: 0;">A smaller heading</h3><br><br>
          <strong>*</strong>Italic text<strong>*</strong> = <em>Italic text</em><br><br>          
          <strong>**</strong>Bold text<strong>**</strong> = <strong class="regular">Bold text</strong><br><br>

          <strong>-</strong> This is<br>
          <strong>-</strong> A list of<br>
          <strong>-</strong> Unordered items<br><br>          
          
          <strong>1.</strong> Another list<br>
          <strong>2.</strong> of ordered<br>
          <strong>3.</strong> items<br><br>
          
          <strong>[</strong>A link to google<strong>](</strong>http://google.com<strong>)</strong> = <a href="http://google.com">A link to google</a>
          <hr>
          <p><br><a href="http://daringfireball.net/projects/markdown/syntax" target="_blank">More supported formatting with Markdown &rarr;</a></p>
          
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
