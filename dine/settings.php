<?php

/**
 * Settings
 */

$db_name = 'dine.sqlite';
define('ABSPATH', str_replace('\\', '/', dirname(__FILE__)) . '/');

date_default_timezone_set('Australia/Brisbane');

$upload_path = ABSPATH . "../images/uploads/";

$is_cached = false; // Set to true to enable page caching in HTML
$cachetime = 120; // cache time in seconds 3600 = 1 hour

$currency = '$';

