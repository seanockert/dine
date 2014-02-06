<div class="container">
  
  <div class="hero clearfix">
    <div class="row">
        <div class="columns large-4">
          <h1><a href="./" title="Return to homepage"><?php echo $siteOptions['name']; ?></a></h1>  
        </div> 
         
        <div class="columns large-3 small-6">
          <?php echo nl2br($siteOptions['hours']); ?>
        </div>          
        
        <div class="columns large-3 small-6">
          <?php echo nl2br($siteOptions['address']); ?> 
        </div>          
        
        <div class="columns large-2">
          <a href="menu.php" class="menu">Menu</a> 
        </div>                   
        
    </div>
  </div>
  
  <div class="row">
      <div class="content">
        <?php if (count($contents) > 0) {  
          foreach($contents as $content) { ?>
              <div class="columns large-6">
              <h3><?php echo $content['title']; ?></h3>
              <p><?php echo nl2br($content['content']); ?></p> 
              </div> 
          <?php } ?>          
        <?php } ?>
        
        
        <?php if (count($images) > 0) {  
          foreach($images as $image) { ?>
          <div class="image columns large-6">
              <img src="img/uploads/<?php echo $image['src']; ?>" title="<?php echo $image['title']; ?>">
          </div>    
          <?php } ?>          
        <?php } ?> 
       
        <div class="clear"></div>
        
    </div>  
  </div>  
    