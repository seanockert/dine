<?php

/**
 * Site details
 */
$site_title = 'My Restaurant';
$site_author = 'Sean Ockert';
$site_description = 'Fine Chicken Dining';
$db_name = 'dinedb.sqlite';
$uploadpath = "../img/uploads/";
$categories = array('Entree', 'Mains', 'Dessert');

$email = "enquiries@restaurant.com";
$phone = "07 5555 5555";
$address = "28 Example St <br>Brisbane QLD 4000, Australia";
$openingHours = "11am-late";

/**
 * Administrator account details
 */
$username = 'admin';
$password = 'admin'; // Don't store in config - only store hash
$salt = 's9$4g;/.H+%FHD8lJM+-UjTP68|,+AHG?dj:hK7nT%%s;_(W;fCbGfmJx,eZKqL~';
$hashed = sha1($password . $salt); // 124a5e5e7464cd95d5305c77b012049e1b754fd2

/**
 * Google Analytics tracking code
 */
$google_analytics_code = 'UA-XXXXX-X';


/**
 * System Messages
 */
$error_auth_failed = "Username or password is incorrect";
$editor_save_success = "Changes Saved";
$editor_save_error = "Changes could not be saved";

function url(){
  $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
  return $protocol . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}