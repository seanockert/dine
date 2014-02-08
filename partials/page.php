<div class="container">
  
  <div class="hero clearfix">
    <div class="row">
        <div class="columns large-12">
          <h1><a href="./" title="Return to homepage"><?php echo $site_options->name; ?></a></h1>  
        </div> 

        <div class="columns large-4 small-6 hours">
          <h3>Open Hours</h3>
          <?php echo nl2br($site_options->hours); ?><br>
          <?php echo $helper->format_days($site_options->days); ?>
        </div>          
        
        <div class="columns large-5 small-6 location">
          <h3>Address</h3>
          <?php echo nl2br($site_options->address); ?><br>
          <a href="<?php echo $helper->map_address($site_options->address); ?>" title="View on Google Maps">View on map</a> 
        </div> 
        
        <div class="columns large-3">
          <a href="menu.php" class="menu">Dining Menu</a> 
        </div>           
        
       
        <div class="clear"></div>
    </div>
  </div>
  
  <div class="row">
      <div class="content">
        <?php if (count($contents) > 0) {  
          foreach($contents as $content) { ?>
              <div class="columns large-6">
              <h3><?php echo $content->title; ?></h3>
              <p><?php echo nl2br($content->content); ?></p> 
              </div> 
          <?php } ?>          
        <?php } ?>
        
        
        <?php if (count($images) > 0) {  
          foreach($images as $image) { ?>
          <div class="image columns large-6">
              <img src="images/uploads/<?php echo $image->src; ?>" title="<?php echo $image->title; ?>">
          </div>    
          <?php } ?>          
        <?php } ?> 
       
        <div class="clear"></div>
        <br>
        
        <div class="columns large-4 large-centered medium-centered">
          <h3><?php
            if ($helper->is_open($site_options->days)) {
                echo 'Yes, we\'re open today.';
            } else {
               echo 'Sorry, we\'re not open today.';       
            }
          ?></h3>
          Contact us by phone: <?php echo $site_options->phone; ?> 
          <br>or email: <a href="mailto:<?php echo $site_options->email; ?>"><?php echo $site_options->email; ?></a>
        </div>
    </div>  
  </div>  
    