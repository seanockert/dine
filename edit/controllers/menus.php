<?php
session_start();
require('../../dine/db.php');

$action = $_POST['action'];

if ($_SESSION['user'] == true) {
  try
  {   

    //Save the item to database
    if($action == 'add')
    {

      $title = $_POST['title'];
      $description = $_POST['description'];
      $price = $_POST['price'];
      $category = $_POST['category'];
      $item_order = '0';
      
      $data = array(
          'title' => $title,
          'description' => $description,
          'price' => $price,
          'category' => $category,
          'item_order' => $item_order
      );
    
      $query = $DB->create('items', $data);      

    }
    
    else if($action == 'update')
    {
      $id = $_POST['id'];
      $title = $_POST['title'];
      $description = $_POST['description'];
      $price = $_POST['price'];
      $category = $_POST['category'];
      $item_order = $_POST['item_order'];
      if ($item_order == '') { $item_order = 0;}
    
      $data = array(
          'title' => $title,
          'description' => $description,
          'price' => $price,
          'category' => $category,
          'item_order' => $item_order
      );
    
      $query = $DB->update('items', $data, $id);      

    } 
    
     else if($action == 'order')
    {
      $id = $_POST['id'];
      $item_order = $_POST['item_order'];

      $query = $db->exec("UPDATE items SET 'item_order' = $item_order WHERE id = '$id';");
      
      if($query == 0) {
        $message = "Something went wrong and your item's order was not updated. Please try again.";
        $alertType = "alert-error active";
      } else {
        $message = "Item moved successfully";
        $alertType = "alert success active";
      }   
    }  
      
    /*
      Delete by ID
    */
    else if($action == 'delete')
    {
      $query = $DB->delete('items', $_POST['id']);
    }
 
    else if($action == 'add-option')
    {

      $parent_id = $_POST['parent_id'];
      $title = $_POST['title'];
      $price = $_POST['price'];
      $item_order = '0';
      
      $data = array(
          'parent_id' => $parent_id,
          'title' => $title,
          'price' => $price,
          'item_order' => $item_order
      );
    
      $query = $DB->create('subitems', $data); 
    }
      
    else if($action == 'delete-option')
    {
      $query = $DB->delete('subitems', $_POST['id']);
    }
    $DB->flush_cache();
  	header('Location: ../menus.php');
  }


  catch(PDOException $e)
  {
    print 'Exception : '.$e->getMessage();
  }
  
} else {
	header('Location: ../login.php');
}   