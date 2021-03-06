        <div class="row">    
            
            <div id="footer" class="columns large-12">
                &copy 2014 Dine by <a href="http://balsamade.com">Sean Ockert</a>
                <?php //if(isset($_SESSION['user'])){ ?>
                | <a href="edit/" title="Edit this page">Edit</a>
                <?php //} ?>
            </div>
            
        </div>  
    </div>  
    <script src="js/vendor/instantclick.min.js" data-no-instant></script>         
    <script src="js/plugins.js" defer></script>
    <script data-no-instant>InstantClick.init();</script>
    <script>
        window.addEventListener('load', function() {
            FastClick.attach(document.body);
        }, false);      
    </script>

    <?php if($site_options->analytics_code != '') { ?>
    <script>
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', '<?php echo $site_options->analytics_code; ?>']);
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

<?php if ($is_cached) $helper->end_cache($page); ?>