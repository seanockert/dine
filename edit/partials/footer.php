	<div id="footer">
		<a href="http://balsamade.com/dine" class="logo left"><img src="../images/dine-logo-mute.png"></a>
        <a href="#" id="viewtoggle" class="right">View full site</a>
	</div>
    
    <script src="../js/vendor/jquery.min.js"></script>
    <script src="../js/vendor/responsive-nav.min.js"></script>      
    <script src="../js/vendor/instantclick.min.js" data-no-instant></script>   
    <script src="../js/editor/jquery.reveal.js"></script>    
    <script src="../js/editor/slip.js"></script>      
    <script src="<?php //echo $_SERVER[HTTP_HOST] . $_SERVER[REQUEST_URI]; ?>../js/editor/editor.js?v=2"></script>  
    <script data-no-instant>InstantClick.init();</script>      
    <script>
      var navigation = responsiveNav('.nav-collapse', {
        transition: 250,
        label: 'Menu',
        insert: 'after',
        customToggle: '#menu',
        openPos: 'relative', 
        open: function () {
          var menu = document.getElementById("menu");
          menu.className = menu.className.replace(/(^|\s)open(\s|$)/, 'close ');
        },
        close: function () {   
          var menu = document.getElementById("menu");      
          menu.className = menu.className.replace(/(^|\s)close(\s|$)/, 'open ');
        }
      });
    </script>  


    <?php 
    // Clear alert after each page reload
    $_SESSION['alertType'] = ''; 
    $_SESSION['message'] = ''; 
    ?>   
  </body>
</html>