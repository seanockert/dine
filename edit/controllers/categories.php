<?php
session_start();
require('../../dine/db.php');

$action = $_POST['action'];
$message = $alertType = '';
$_SESSION['message'] = $_SESSION['alertType'] = '';


if ($_SESSION['user'] == true) {
  try
  {   

    //Save the contents to database
    if($action == 'add')
    {

      $data = array(
          'title' => $_POST['title'],
          'category_order' => 0,
      );
    
      $query = $DB->create('categories', $data);

    }
     
    /*
      Delete by ID
    */
    else if($action == 'delete')
    {
      $query = $DB->delete('categories',$_POST['id']);
    }
      
    //close the database connection
    $db = NULL;

  	header('Location: ../menus.php');
  }


  catch(PDOException $e)
  {
    print 'Exception : '.$e->getMessage();
  }
  
} else {
	header('Location: ../login.php');
}   