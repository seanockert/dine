<div class="container">
   <div class="row">
        <header>
            <a href="menu.php" class="right button">Menu</a>                    
            <h1><a href="./" title="Return to homepage"><?php echo $siteOptions['name']; ?></a></h1>
        </header>
         <div class="content">
          <?php if (count($contents) > 0) {  
            foreach($contents as $content) { ?>
           
                <h3><?php echo $content['title']; ?></h3>
                <p><?php echo nl2br($content['content']); ?></p>  
            <?php } ?>          
          <?php } else {
            echo '<li><em>Coming soon.</em></li>';
          } ?>
          
          <?php if (count($images) > 0) {  
            foreach($images as $image) { ?>
            <div class="image">
                <img src="img/uploads/<?php echo $image['src']; ?>" title="<?php echo $image['title']; ?>">
            </div>    
            <?php } ?>          
          <?php } ?> 
         
        <h3>Address</h3>       
        <?php echo nl2br($siteOptions['address']); ?> 
        
        <h3>Opening Hours</h3>
        <?php echo nl2br($siteOptions['hours']); ?> 
        
        </div>  