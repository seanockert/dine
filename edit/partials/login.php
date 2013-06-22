<body id="login">
     <div class="row" id="header">
        <div class="large-12 columns">   
           <form method="POST" action="?action=login">
                <h2>Login to Edit Website.</h2>
                <fieldset>
                    <div class="clearfix">
                        <?php if(isset($login_error)): ?>
                            <p class="alert-message error"><?php echo $login_error; ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="clearfix">
                        <label for="username">Username</label>
                        <div class="input">
                            <input type="text" name="username" id="username" placeholder="Type your username here">
                        </div>
                    </div>
                    <div class="clearfix">
                        <label for="password">Password</label>
                        <div class="input">
                            <input type="password" name="password" id="password" placeholder="Type your password here">
                        </div>
                    </div>
                    <div>
                        <input type="submit" class="button green" value="Login">
                    </div>
                </fieldset>
                <p><a class="brand" href="../">&larr; Back to <?php echo $site_title; ?></a></p>
            </form>
                
            
        </div>    
    </div>    

    
    <script src="../js/jquery.min.js"></script>
    <script src="../js/edit.js"></script>    
</body>
</html>
