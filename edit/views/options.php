<?php
  if ($_SESSION['user'] == true) {
    
    $options = $DB->read('options');     
?>
  
  <body id="edit">

    <div id="sidebar"> 
      <h2><a class="brand" href="../" title="Return to site"><?php echo $siteTitle['content']; ?></a></h2>
      <nav>
        <ul>
            <li><a href="./">Content</a></li>  
            <li><a href="./menus.php">Menus</a></li>   
            <li><a href="./photos.php">Photos</a></li>   
            <li><a href="./options.php" class="active">Options</a></li>   
            <li><a href="controllers/login.php?action=logout" class="logout">Log Out</a></li>   
        </ul>
      </nav>   
    </div> 

    <div id="content">
        
        <div id="header">
            <h1>Edit Options</h1>
            <div class="clear"></div> 
        </div>

        <div class="<?php echo $_SESSION['alertType']; ?>"><?php echo $_SESSION['message']; ?></div>
        <form method="post" action="controllers/options.php">
        <?php
        if ($options) {
          while($option = $options->fetch()) { ?>      
          <div class="option">
               <?php if ($option['type'] == 'username') { ?>
              <br><hr>
              <?php } ?>  
              <label><?php echo ucfirst(str_replace('_', ' ', $option['type'])); ?></label>
              
              <?php if ($option['type'] == 'address' || $option['type'] == 'hours') { ?>
              <textarea name="content[]" class="short" placeholder=""><?php echo $option['content']; ?></textarea>
              <?php } else { ?>
              <input type="text" name="content[]" value="<?php echo $option['content']; ?>">
              <?php } ?>
              <!--<input type="hidden" name="type" value="<?php echo $option['type']; ?>">-->
          </div>
        <?php }
        } ?> 
          
          <input type="hidden" name="action" value="update-all">   
                
          <div class="clear"></div><br>
          <p><input type="submit" name="submit" value="Update Options" class="button green"></p>
        
        </form>
        
        <hr>
        <div class="tools">
          <h3>Tools</h3>
          <form method="post" class="left" action="controllers/options.php">
            <input type="hidden" name="action" value="flushcache">
            <p><br><input type="submit" name="submit" class="button blue" value="Flush Cache" /></p>
          </form>        
          <!--<form method="post" class="left" action="controllers/options.php">
            <input type="hidden" name="action" value="setup">
            <input type="submit" name="submit" value="Setup Database" />
          </form>-->
        </div>
        
        <div class="clear"></div>

    </div>

  <?php include('footer.php'); ?>

<?php 
} 
else 
{
  header('Location: /login.php');
}
