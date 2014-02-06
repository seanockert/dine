<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require('../credentials.php');

session_start(); 

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    switch ($action) {
    case 'login':           
        /* Authentication attempt */
        if ((isset($_POST['username']))
        && (isset($_POST['password']))
        && ($_POST['username'] === $username)
        && ($_POST['password'] === $password))
        {
            $_SESSION['user']=true;
            $_SESSION['message'] = "Signed in. Start editing!";
            $_SESSION['alertType'] = "alert success active";
        }else{
            //$login_error = $error_auth_failed;
            $_SESSION['message'] = "Sign in failed. Username or password was incorrect.";
            $_SESSION['alertType'] = "alert error active"; 
        }
        break;
    case 'logout':          
        /* End session */
        session_unset();
        session_destroy();
        
        $_SESSION['message'] = "You're now logged out";
        $_SESSION['alertType'] = "alert success active";
        break;
    }
    header('Location: ../index.php');
} 