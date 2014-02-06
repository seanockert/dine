<?php

$db_name = 'dine.sqlite';
define('ABSPATH', str_replace('\\', '/', dirname(__FILE__)) . '/');



/**
 * Site details
 */
$site_title = 'My Restaurant';
$site_description = 'Fine dining';

$uploadpath = ABSPATH . "../images/uploads/";

$is_cached = true; // Set to true to enable page caching in HTML
$cachetime = 3600; // cache time in seconds 3600 = 1 hour



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

function url(){
  $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
  return $protocol . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}