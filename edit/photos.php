<?php
    include('partials/header.php');

if(!isset($_SESSION['user'])){      /* Not logged in */
    // Show login form
    include('views/login.php');
}else{                              /* Logged in */
    // Show form
    include('views/photos.php');
}

