Dine
====

A simple CMS for single page websites. Specifically restaurants and small businesses that often want to display a list of their inventory or menu items without a full-blown stock CMS.

Check out a demo here: [http://balsamade.com/dine/](http://balsamade.com/dine/)  

Login and edit content: http://%yoursite%/edit/ 
    Username: admin
    Password: admin

- Has content sections, dining menu and image upload 
- Stores everything in an SQLite database at /appdata/dinedb.sqlite 
- Works out of the box - set your admin password in credentials.php and you're all set
- The admin password and all config settings are set in /appdata/config.php
- Uses a custom version of Zurb Foundation for the dashboard CSS styling. I've kept it minimal and you can strip it out
- Basic caching for PHP views and CSS/JS (Smartoptimizer)
- NO WYSIWYG! Seriously, those things are a pain for everyone. A good design shouldn't need a WYSIWYG but feel free to shoehorn TinyMCE in there

Dine is free to do what you like with. I intend to update it more frequently now. Coming soon: drag and drop menu ordering, responsive dashboard, updated base template, routing, AJAX goodness, better caching.
