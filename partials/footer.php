        <div class="row">    
            
            <div id="footer" class="columns large-12">
                &copy 2014 <a href="http://balsamade.com/dine">Dine</a>  
                <?php //if(isset($_SESSION['user'])){ ?>
                | <a href="edit/menu.php" title="Edit this page">Edit</a>
                <?php //} ?>
            </div>
            
        </div>  
    </div>  
    <script src="js/vendor/jquery.min.js"></script>
    <script src="js/scripts.js"></script>       
    <script src="js/plugins.js" defer></script>

    <?php if($siteOptions["analytics_code"] != '') { ?>
    <script>
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', '<?php echo $siteOptions["analytics_code"]; ?>']);
        _gaq.push(['_trackPageview']);
        (function() {
        var ga = document.createElement(‘script’); ga.type = ‘text/javascript’; ga.async = true;
        ga.src = (‘https:’ == document.location.protocol ? ‘https://ssl’ : ‘http://www’) + ‘.google-analytics.com/ga.js’;
        var s = document.getElementsByTagName(‘script’)[0]; s.parentNode.insertBefore(ga, s);
        })();
    </script>
    <?php } ?>
    </body>
</html>

<?php if ($is_cached) end_cache($page); ?>