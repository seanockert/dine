<?php
require('../dine/loader.php'); 

session_start(); 

$title = $DB->readSingle('options','content',1);

if (!$_SESSION['alertType']) {
    $_SESSION['alertType'] = '';
}
if (!$_SESSION['message']) {
    $_SESSION['message'] = '';
}

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="shortcut icon" sizes="32x32" href="../images/favicon.png">  
    <title>Editing <?php echo $title->content; ?></title>
    <link rel="stylesheet" type="text/css" href="../css/editor/editor.css"></link>
  </head>
