<?php
include('partials/header.php');

if(!isset($_SESSION['user'])){      /* Not logged in */
    // Show login form
    include('partials/login.php');
}else{                              /* Logged in */
    // Show form
    include('partials/edit-menu.php');
}

