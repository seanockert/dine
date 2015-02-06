<?php
session_start();
require('../../dine/db.php');
require('../../dine/Parsedown.php');

$action = $_POST['action'];

if ($_SESSION['user'] == true) {
  try
  {   

    // Add a new content section to the database
    if($action == 'add')
    {
      $title = $_POST['title'];
      $content = trim($_POST['content']); 
      $markdown = $content;
      $content = Parsedown::instance()->set_breaks_enabled(false)->parse(SQLite3::escapeString($content));
  
      $position = $_POST['position'];
      
      $data = array(
          'title' => $title,
          'content' => $content,
          'markdown' => $markdown,
          'position' => $position
      );
    
      $query = $DB->create('contents', $data);

    }
   
    // Update a content section
    else if($action == 'update')
    {
      $id = $_POST['id'];
      $title = $_POST['title'];
      $content = trim($_POST['content']);
      $markdown = $content;
      // Convert Markdown to HTML
      $content = Parsedown::instance()->set_breaks_enabled(false)->parse(SQLite3::escapeString($content)); 
      
      // Position not used yet
      $position = $_POST['position'];
      
      $data = array(
          'title' => $title,
          'content' => $content,
          'markdown' => $markdown,
          'position' => $position
      );
    
      $query = $DB->update('contents', $data, $id);

    } 
    
    // Delete a content section by ID
    else if($action == 'delete')
    {
      $query = $DB->delete('contents', $_POST['id']);
    }
    $DB->flush_cache(); 
  	header('Location: ../index.php');
  }


  catch(PDOException $e)
  {
    print 'Exception : '.$e->getMessage();
  }
  
} else {
  // Redirect to login page if not logged in
	header('Location: ../login.php');
}   