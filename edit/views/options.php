<?php
  if ($_SESSION['user'] == true) {
    $options = $DB->read('options');  
    
    // Takes the list of currently active days and outputs a list of days of the week for selection
    function days_list($data) {
      $current_days = explode(',', $data);
      $days = ['monday','tuesday','wednesday','thursday','friday','saturday','sunday'];
      $selected_days = [0,0,0,0,0,0,0];
      
      $day_list = '<ul id="days-list" class="nolist">';
      $active = '';
      $i = 0;
      foreach ($days as $day) {
        if ($current_days[$i] == 1) { 
          $active = 'active';
          $selected_days[$i] = 1; 
        } else {
          $active = '';
        }
        
        $day_list .= '<li class="' . $active . '" data-active="' . $selected_days[$i] . '" data-index="' . $i . '">' . ucfirst($day) . '</li>';
        ++$i;
      }
      
      return $day_list;
      
    }   
?>
  
  <body id="edit">

    <?php 
      $active = 'options';
      include('partials/nav.php'); 
    ?>

    <div id="content">
        
        <div id="header">
            <h1>Edit Options</h1>
            <div class="clear"></div> 
        </div>

        <div class="<?php echo $_SESSION['alertType']; ?>"><?php echo $_SESSION['message']; ?></div>
        <form method="post" action="controllers/options.php">
        <?php if (count($options) > 0) {
          foreach($options as $option) { ?>     
          <div class="option">
               <?php if ($option->type == 'username') { ?>
              <br><hr>
              <?php } ?>  
              <label><?php echo ucfirst(str_replace('_', ' ', $option->type)); ?></label>
              
              <?php if ($option->type == 'address') { ?>
                <textarea name="content[]" class="short" placeholder=""><?php echo $option->content; ?></textarea>
              <?php } else if ($option->type == 'hours') { ?>
                <input type="text" name="content[]" value="<?php echo $option->content; ?>" placeholder="9am - 5pm">
              <?php } else if ($option->type == 'days') { ?>
                <?php echo days_list($option->content); ?>
                <input type="hidden" name="content[]" id="days-input" value="<?php echo $option->content; ?>">
              <?php } else { ?>
                <input type="text" name="content[]" value="<?php echo $option->content; ?>">
              <?php } ?>
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
          <p>If you've updated some content but it's not showing up on the site, click this button to clear the cached files.</p>
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

  <?php include('partials/footer.php'); ?>

<?php 
} 
else 
{
  header('Location: /login.php');
}
