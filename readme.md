Dine
====

A simple CMS for single page websites. Specifically restaurants and small businesses that often want to display a list of their inventory or menu items without a full-blown stock CMS.

Check out a demo here: [http://balsamade.com/dine/](http://balsamade.com/dine/)  

Login and edit content: http://%yoursite%/edit/ 
    Username: admin
    Password: admin

- Has editable content sections, dining menu (or inventroy list), image upload
- Shop options like open hours/days and closed dates, address (auto linked to Google Maps)
- Stores everything in an SQLite database at /appdata/dinedb.sqlite 
- Works out of the box - change the admin password in credentials.php and you're all set
- The config settings are set in options table and in /dine/settings.php
- Responsive with Zurb Foundation grid. Base theme is fairly minimal and easily customisable
- Basic caching for PHP views and CSS/JS (Smartoptimizer)
- Markdown for styling content

I intend to update it more frequently now. 
Coming soon: drag and drop menu ordering, responsive dashboard, updated base template, routing, AJAX goodness, better caching.

##Licence

The MIT License

Copyright (c) 2014 Sean Ockert http://balsamade.com/


