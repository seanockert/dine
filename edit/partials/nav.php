    <div id="sidebar"> 
      <h2><a class="brand" href="../" title="Return to site"><?php echo $title->content; ?></a></h2>
    <button class="open nav-menu x" type="button" role="button" id="menu" aria-label="Toggle Navigation">
        <span class="lines"></span>
    </button>
      <nav class="nav-collapse">
        <!--<a href="#" id="menu-icon"><div></div><div></div><div></div></a>-->


            <ul>
            <?php
                $navitems = array();
                $navitems = ['content','menus','photos','options'];
                $output = '';
             
                foreach($navitems as $navitem) {
                    $class = '';
                    $url = $navitem;  
                    
                    if ($navitem == $active) {
                        $class = 'class="active"';
                    } 
                                   
                    if ($navitem == 'content') {
                       $url = 'index'; 
                    } 
                                       
                    $output .= '<li><a href="' . $url . '.php" ' . $class . ' data-instant>' . ucfirst($navitem) . '</a></li>';
                }
                
                echo $output;
                
            ?>
                <li><a href="controllers/login.php?action=logout" class="logout">Log Out</a></li>   
            </ul>
             
      </nav>   
     
    </div> 
