<?php

/**
 * Settings
 */

$db_name = 'dine.sqlite';
define('ABSPATH', str_replace('\\', '/', dirname(__FILE__)) . '/');

date_default_timezone_set('Australia/Brisbane');


/**
 * Site details
 */
$site_title = 'My Restaurant';
$site_description = 'Fine dining';

$upload_path = ABSPATH . "../images/uploads/";

$is_cached = true; // Set to true to enable page caching in HTML
$cachetime = 120; // cache time in seconds 3600 = 1 hour

$currency = '$';


/**
 * Functions
 */

// Input: 
// Output: an ordered array for the menu items
// TODO; Clean this up
function array_orderby() {
    $args = func_get_args();
    $data = array_shift($args);
    foreach ($args as $n => $field) {
        if (is_string($field)) {
            $tmp = array();
            foreach ($data as $key => $row)
                $tmp[$key] = $row[$field];
            $args[$n] = $tmp;
            }
    }
    $args[] = &$data;
    call_user_func_array('array_multisort', $args);
    return array_pop($args);
}


// TODO: remove this if not being used
function url(){
  $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
  return $protocol . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}

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
// Output: nicely formatted open days
function format_days($days) {
    $current_days = explode(',', $days);
    $days = ['Mon','Tues','Wed','Thurs','Fri','Sat','Sun'];
    $i = 0;
    $output = '';
    $separator = ' - ';
    $count = 0;
    
    foreach ($current_days as $day) {

        if ($current_days[$i] == 1) { 
            // Start count on number of active days 
            $count = $count + 1; 

            if ($i > 0 && $i < 6) {
                if ($current_days[$i-1] == 1 && $current_days[$i+1] == 1) {
                    $output .= $separator;
                    $separator = '';
                } else {
                    if ($separator != '') {
                        $output .= ', ';
                    }
                    $output .= $days[$i];
                    $separator = ' - '; 
                }
                
                 
             } else {
               // Last day so output normally
               $output .= $days[$i];
             }           
          
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