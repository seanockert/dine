<?php
global $DB;

define('DBPATH', str_replace('\\', '/', dirname(__FILE__)) . '/' . '../appdata/dine.sqlite');

class database {
  
  public $db_name = 'dine.sqlite';
  public $db_path = DBPATH;
  
  // Set up options
  public $options = [
    'name',
    'description',
    'address',
    'phone',
    'email',
    'hours',
    'days',
    'days_closed',
    'analytics_code'
  ];
  
  public function setup() {
      $db = new PDO("sqlite:$this->db_path");
      
      //create a table in the database
      $db->exec("CREATE TABLE contents (id INTEGER PRIMARY KEY, title TEXT, content TEXT, markdown TEXT, position TEXT, date_modified TEXT, date_created TEXT)");
      $db->exec("CREATE TABLE categories (id INTEGER PRIMARY KEY, title TEXT, category_order INTEGER, date_modified TEXT, date_created TEXT)");
      $db->exec("CREATE TABLE items (id INTEGER PRIMARY KEY, title TEXT, description TEXT, price TEXT, category TEXT, item_order INTEGER, date_modified TEXT, date_created TEXT)");
      $db->exec("CREATE TABLE subitems (id INTEGER PRIMARY KEY, parent_id INTEGER, title TEXT, price TEXT, item_order INTEGER, date_modified TEXT, date_created TEXT)");
      $db->exec("CREATE TABLE options (id INTEGER PRIMARY KEY, type TEXT, content TEXT, date_modified TEXT, date_created TEXT)");
      $db->exec("CREATE TABLE photos (id INTEGER PRIMARY KEY, title TEXT, src TEXT, date_modified TEXT, date_created TEXT)");
      
      // Prefill Options table
      foreach ($this->options as $option) 
      { 
        
        $content = '';
        
        if ($option == 'name') 
        {
          $content = 'Shop';
        }
        
        $data = array(
            'type' => $option,
            'content' => $content,
        );
      
        $query = $this->create('options', $data);    
        
      }

      $_SESSION['message'] = "Database setup complete";
      $_SESSION['alertType'] = "alert success active";    
    
  }  
  public function create($table, $data, $success = null) {
 
    // Created timestamp
    $date_created = time(); 

    try {
      // Open database
      $db = new PDO("sqlite:$this->db_path");
      $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING ); 
      
      // Add created and modified timestamp to data array
      $data['date_modified'] = $date_created;
      $data['date_created'] = $date_created;

      // Split array keys into 2 strings
      $keys = $values = array();
      foreach (array_keys($data) as $name) {
        $keys[] = $name;
        $values[] = ':' . $name;
      }
      $keys = implode(', ', $keys);
      $values = implode(', ', $values);
      
      // Create new row in given $table with values
      $insert = $db->prepare("INSERT INTO $table($keys) values ($values)");  
      $query = $insert->execute($data);  
      $db = NULL;    
                    
      if($query) {
        $_SESSION['message'] = "Created successfully";
        $_SESSION['alertType'] = "alert success active";
      }  else {
        $_SESSION['message'] = "Something went wrong and your data was not saved";
        $_SESSION['alertType'] = "alert error active";
      }
      
      header('Location: index.php');
      //return $query;  
            
    } catch (PDOException $e) {
      
      return 'Connection failed: ' . $e->getMessage();
      
    }     
    
  }

  public function read($table, $order = 'id') {
    
    try {

      $db = new PDO("sqlite:$this->db_path");
      $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
      
      $rows = $db->query('SELECT * FROM ' . $table . ' ORDER BY "' . $order . '"');
      $rows->setFetchMode(PDO::FETCH_ASSOC);
      $db = NULL;
      
      // Return an object
      $data = $this->array_to_object($rows);
      return $data;  
            
    } catch (PDOException $e) {
      
      return 'Connection failed: ' . $e->getMessage();
      
    }
    
  }  
  
  public function readSingle($table, $col, $id) {
    try {
      
      $db = new PDO("sqlite:$this->db_path");
      $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
      
      $row = $db->query('SELECT ' . $col . ' FROM ' . $table . ' WHERE id=' . $id);
      $row->setFetchMode(PDO::FETCH_ASSOC);
      $db = NULL;
      
      // Return an object
      $data = $this->array_to_object($row);      
      
      return $data->{'0'};  
            
    } catch (PDOException $e) {
      $this->setup();
      //return 'Connection failed: ' . $e->getMessage();
      
    } 
  }  
  
  // Input: the table name and ID of the page
  // Output: the page data
  // TODO: this function is currently unused
  public function readPage($table, $id) {
    try {
      
      $db = new PDO("sqlite:$this->db_path");
      $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
      
      $row = $db->query('SELECT * FROM ' . $table . ' WHERE id=' . $id);
      $row->setFetchMode(PDO::FETCH_ASSOC);
      $db = NULL;
      
      return $row;  
            
    } catch (PDOException $e) {
      $this->setup();
      //return 'Connection failed: ' . $e->getMessage();
      
    } 
  }

  // Input: table name, an array of data to update, the row ID, custom success message
  // Output: update the row data in the specified table
  public function update($table, $data, $id, $success = null) {
    
    // Created timestamp
    $date_modified = time(); 

    try {
      // Open database
      $db = new PDO("sqlite:$this->db_path");
      $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING ); 
      
      // Add created and modified timestamp to data array
      $data['date_modified'] = $date_modified;
      
      $values = $this->array_to_pdo_params($data);
      
      $update = $db->prepare("UPDATE $table SET $values WHERE id = '$id'");
      $query = $update->execute($data);  
      $db = NULL;    
               
      if($query) {
        if ($success) {
          $_SESSION['message'] = $success;  
        } else {
          $_SESSION['message'] = "Updated successfully";        
        }         
        $_SESSION['alertType'] = "alert success active";     
      }  else {
        $_SESSION['message'] = "Something went wrong and your data was not updated";
        $_SESSION['alertType'] = "alert error active";           
      }
      return $query;  
            
    } catch (PDOException $e) {
      
      return 'Connection failed: ' . $e->getMessage();
      
    }     
           
  }

  // Input: table name, row ID, custom success message
  // Output: delete the row from the table
  public function delete($table, $id, $success = null) {
    
    try {
      
      $db = new PDO("sqlite:$this->db_path");
      $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );

      $query = $db->exec("DELETE FROM $table WHERE id = '$id';");
      if($query) {
        if ($success) {
          $_SESSION['message'] = $success;  
        } else {
          $_SESSION['message'] = "Item deleted";         
        }
        $_SESSION['alertType'] = "alert success active";
      } else {
        $_SESSION['message'] = "Something went wrong. Item was not deleted";
        $_SESSION['alertType'] = "alert error active";       
      }     
      return 'deleted';  
            
    } catch (PDOException $e) {
      
      return 'Connection failed: ' . $e->getMessage();
      
    }     
    
      
  }
  
  // Input: a data array sent from the form
  // Output: a formatted array for updating the database
  public function array_to_pdo_params($array) {
    $temp = array();
    foreach (array_keys($array) as $name) {
      $temp[] = "'$name' = :$name";
    }
    return implode(', ', $temp);
  }
  
  // Force the views to update by removing the cache files
  public function flush_cache() {
      $files = glob('../../cache/*');
      foreach($files as $file){
        if(is_file($file))
          unlink($file);
      }
      if( ob_get_level() > 0 ) ob_flush(); 
  }
  
  // Input: an array from the database
  // Output: an object
  public function array_to_object($array) {
    $obj = new stdClass;
    foreach($array as $k => $v) {
       if(strlen($k)) {
          if(is_array($v)) {
             $obj->{$k} = $this->array_to_object($v); //RECURSION
          } else {
             $obj->{$k} = $v;
          }
       }
    }
    return $obj;
  }   
  
} 

$DB = new database();
