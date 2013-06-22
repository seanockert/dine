Dine
====

A barebones CMS for single page websites. 

Check out a demo here: [http://balsamade.com/dine/](http://balsamade.com/dine/)  

Login and edit stuff: http://%yoursite%/edit/ 
Username: admin
Password: admin

- Has content sections, dining menu and image upload. 
- Stores everything in an Sqlite database at /appdata/dinedb.sqlite 
- Works out of the box.
- The admin password and all config settings are set in /appdata/config.php
- Uses a custom version of Zurb Foundation for the dashboard CSS styling. I've kept it minimal and you can strip it out
- Basic caching for PHP views and CSS/JS (Smartoptimizer)
- NO WYSIWYG! Seriously, those things are a pain for everyone. A good design shouldn't need a WYSIWYG but feel free to shoehorn TinyMCE in there

There's definately things to improve, like adding drag and drop sorting to menu items (currently you can change the order number on an item to sort them), submitting updates via AJAX and making the dashboard fully responsive.

Dine is free to do what you like with but if you happen to use this anywhere or modify it, I'd love to hear from you (seanockert@gmail.com). Ditto if you have any suggestions or improvements.

