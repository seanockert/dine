<?php
session_start();
include('../appdata/config.php');

$current_page = 'menu';

if (isset($_GET['action'])) {
        $action = $_GET['action'];
        switch ($action) {
            case 'login':  /* Authentication attempt */
                if ((isset($_POST['username']))
                && (isset($_POST['password']))
                && ($_POST['username']===$username)
                //&& ($_POST['password']===$password))
                && (sha1($_POST['password'] . $salt) === $hashed))
                {
                    $_SESSION['user']=true;
                }else{
                    $login_error=$error_auth_failed;
                }
                break;
            case 'logout':          /* End session */
                session_unset();
                session_destroy();
                break;
    }
} ?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />    
    <title>Edit: <?php echo $site_title; ?></title>
    <link rel="stylesheet" type="text/css" href="../css/style.css"></link>
    <link rel="stylesheet" type="text/css" href="../css/editor.css?v=4"></link>
  </head>
