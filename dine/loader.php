<?php
	// Include the necessary files
    require(__DIR__ . '/settings.php'); // Path, cache settings, currency and timezone
    require(__DIR__ . '/helpers.php'); // Helper functions for for formatting dates and setting cache on the front end. Reference like $helper->function
    require(__DIR__ . '/db.php'); // Database CRUD function reference like $DB->create(), $DB->delete() etc.