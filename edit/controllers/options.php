<?php

require('../../dine/db.php');

session_start();

$action = $_POST['action'];

if ($_SESSION['user'] == true) {
  try
  {   
    /*
      Setup the database by creating tables
    */
    if($action == 'setup')
    {   
        $query = $DB->setup();    
        
    }
    
    //Save the content to database
    else if($action == 'flushcache')
    {  
      $files = glob('../../cache/*');
      foreach($files as $file){
        if(is_file($file))
          unlink($file);
      }
      if( ob_get_level() > 0 ) ob_flush();
      $_SESSION['message'] = "Cache cleared. Your content is now be updated on the public site.";
      $_SESSION['alertType'] = "alert success active";
      
    }

    else if($action == 'update-all')
    {
  
      $date_modified = time();  
      $id = 1;

      foreach ($_POST['content'] as $content) 
      {
        $data = array(
            'content' => $content,
        );
      
        $query = $DB->update('options', $data, $id);         
 
        ++$id; 
      }

    } 
      
  	header('Location: ../options.php');
  }


  catch(PDOException $e)
  {
    print 'Exception : '.$e->getMessage();
  }
  
} else {
	header('Location: ../login.php');
}   