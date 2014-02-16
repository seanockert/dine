<?php

class helper {

    // Input: the street address of the business
    // Output: the URL to Google Maps for that street address
    function map_address($address) {
        return 'http://maps.google.com/?q=' . preg_replace('/[\r\n]+/', '%20', str_replace(' ', '%20', $address));
    }

    // Input: list of days open
    // Output: true if is open today
    function is_open($days) {
        $current_days = explode(',', $days);
        // Shift array by one so we can use the date 'w' comparison and still start on monday
        $temp = $current_days[6];
        array_pop($current_days);
        array_unshift($current_days, $temp);

        $today = date( "w", time());
        if ($current_days[$today] == 1) {
            return true;
        } else {
            return false;    
        }
    }

    // Input list of days open
    // Output: a formatted string of open days
    function format_days($daysString) {
        $days = explode(',', $daysString);
        $weekdays = array('Mon','Tues','Wed','Thurs','Fri','Sat','Sun');
        $separator = ' - ';
        $i = $activeCount = 0;
        
        foreach ($days as $day) {

            if ($day == 1) { 
 
                if ($i > 0 && $i < 7 && $activeCount) { // Is not the first or last day of the week
                    if ($days[$i-1] == 1 && $days[$i+1] == 1) { // If previous and next days are open
                        $output .= $separator;
                        $separator = '';
                    } else {
                        if ($separator != '') {
                            $output .= ', ';
                        }
                        $output .= $weekdays[$i];
                        $separator = ' - '; 
                    }
                    
                     
                 } else {
                   // Last day so output normally
                   $output .= $weekdays[$i];
                 }  
                          
                // Start count on number of active days 
                ++$activeCount; 
            } 
      
            ++$i;
        }
        
        return $output;
    }

    // Input: A comma separated list of days in dd/mm format eg 25/12,01/01
    // Output: A string of days with their common holiday names (if they exist)
    function format_closed_days($daysString) {
        $dates = explode(',', $daysString);    
        $output = '';
        
        // A list of common holidays to compare to
        $common_holidays = array(
            '25/12' => 'Christmas Day',
            '26/12' => 'Boxing Day',
            '31/12' => 'New Years Eve',
            '01/01' => 'New Years Day',
            '20/04' => 'Easter Sunday'
        );
        
        // If the date is a common holiday then replace with the holiday name
        foreach ($dates as $key => $date) {
            if (array_key_exists($date, $common_holidays)) {
                $dates[$key] = $common_holidays[$date];
            }
        }        
 
        $len = count($dates);
        $i = 1;
        
        // Loop through array and add formatting: a comma after each and an & before the last one     
        foreach ($dates as $niceDate) {
            if ($len > 1 && $len == $i) {
              $output .= ' &amp; ' . $niceDate;      
            } else if (($len-1) == $i) {
               $output .= $niceDate;  
            } else {
               $output .= $niceDate;  
               if ($len > 1) { $output .=  ', '; }
            }
            ++$i;
        }
  
        return $output;
    }    


    // Input: the page to cache and the length of time to cache for
    // Output: uses the cached file instead of compiling the PHP
    function set_cache($page, $cachetime) {
        // Path and name of cached file
        $cachefile = 'cache/' . $page . '.html';
        // Check if the cached file is still fresh. If it is, serve it up and exit.
        if (file_exists($cachefile) && time() - $cachetime < filemtime($cachefile)) {
        include($cachefile);
            exit;
        }
        // if there is either no file OR the file to too old, render the page and capture the HTML.
        ob_start();
    }

    // Input: the page to cache
    // Output: saved a copy of the page in the /cache folder
    function end_cache($page) {
        // Save the cached content to a file
        $fp = fopen('cache/' . $page . '.html', 'w');
        fwrite($fp, ob_get_contents());
        fclose($fp);
        // Send browser output
        ob_end_flush();
    }

    // Input: Options object from the database
    // Output: Object formatted by option name and value eg $site_option->description
    function site_options($options) {
        $site_options = new stdClass;
        foreach ($options as $k => $v) {
            $site_options->{$v->type} = $v->content;
        }  
        return $site_options;  
    }  
      
    // Input: an unformatted price value
    // Output: value formatted with the appropriate currency
    // TODO: make locale global
    function format_currency($value) {
        setlocale(LC_MONETARY, 'en_US');
        return money_format('%i', $value);
    }

    // Input: an object to sort by the value $sort
    // Output: a sorted array
    function sort_menu_items($items, $sort) {
         // Create an array for each category of items
        $items_by_category = array();
        foreach($items as $item) {
          $parent = $item->$sort;
          $items_by_category[$parent][] = $item;
        }
        
        return $items_by_category; 
    }

    // TODO: remove this if not being used
    function url(){
      $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
      return $protocol . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }
    
    // Hide the email address from spam bots
    // http://www.givegoodweb.com/post/67/php-email-obfuscate
    function safeEmail($email) {
        $obfuscatedEmail = '';
        //$email = eregi_replace('#','', $email);
        $length = strlen($email);
        for ($i = 0; $i < $length; $i++) {
            $obfuscatedEmail .= "&#" . ord($email[$i]);  // creates ASCII HTML entity
        }
        $return = ''.$obfuscatedEmail.'';
        return $return;
    }
    
    // SQLite escapes apostrophes so replace these
    // Input: Content with double ''
    // Output: Content without double ''
    function cleanContent($content) {
        return str_replace("''", "'", $content);
    }    

}

$helper = new helper();

