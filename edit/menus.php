<?php

if(!isset($_SESSION['user'])){      /* Not logged in */
    // Show login form
    include('views/login.php');
}else{                              /* Logged in */
    // Show menus
    include('partials/header.php');
    include('views/menus.php');
}

