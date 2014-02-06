<?php
require('../dine/db.php');
session_start(); 

$title = $DB->readSingle('options','content',1);
$siteTitle = $title->fetch(); 

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />    
    <title>Editing <?php echo $siteTitle['content']; ?></title>
    <link rel="stylesheet" type="text/css" href="../css/editor/editor.css"></link>
  </head>
