<?php
session_start();
require('../../dine/settings.php');
require('../../dine/db.php');

$action = $_POST['action'];
      


if ($_SESSION['user'] == true) {
  try
  {   

    if($action == 'add')
    {
  
      $src = $_FILES["imgfile"]["name"]; 
      
      $upload = $upload_path.basename($_FILES["imgfile"]["name"]);
      if (!move_uploaded_file($_FILES["imgfile"]["tmp_name"], $upload)) {
        die("There was an error uploading the file, please try again!");
      }    
      $image_name = $upload.$src;
      list($width,$height) = getimagesize($image_name);
      
      //$new_image_name = $upload_path.$_FILES["imgfile"]["name"];
      
      /*
      if ($width > $height) {
        $ratio = (250/$width);
        $new_width = round($width*$ratio);
        $new_height = round($height*$ratio);
      } else {
        $ratio = (250/$height);
        $new_width = round($width*$ratio);
        $new_height = round($height*$ratio);
      }
      
      $image_p = imagecreatetruecolor($new_width,$new_height);
      $img_ext = $_FILES['imgfile']['type'];
      
      if (img_ext == "image/jpg" || img_ext == "image/jpeg") {
        $image = imagecreatefromjpg($image_name);
      } else if ($img_ext == "image/png") {
        $image = imagecreatefrompng($image_name);
      } else if ($img_ext == "image/gif") {
        $image = imagecreatefromgif($image_name);
      } else {
        //die('Not a valid image');
      }

      imagecopyresampled($image_p,$image,0,0,0,0,$new_wi dth,$new_height,$width,$height);
      imagejpeg($image_p,$src,100);
      */
      
      $data = array(
          'title' => $_POST['title'],
          'src' => $src
      );
    
      $query = $DB->create('photos', $data);


    } 
    
    else if($action == 'delete')
    {
      unlink($upload_path . $_POST['src']);
      $query = $DB->delete('photos',$_POST['id']);    
    }    
    
    $DB->flush_cache();
  	header('Location: ../photos.php');
  }


  catch(PDOException $e)
  {
    print 'Exception : '.$e->getMessage();
  }
  
} else {
	header('Location: ../login.php');
}   