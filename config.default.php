<?php
// -------------------------------------------
// webtasks/ bugtracker (by Jannik Beyerstedt)
// simple public task/ bug management system. Based on twitter bootstrap, php, jquery and a json database
// CC BY-NC-SA - Jannik Beyerstedt, jannikbeyerstedt.de, jtByt-Pictures@gmail.com

// file: config.php - config values and switches
// version: 1.1 (2014-10-05)
// changelog: see readme.md
// -------------------------------------------


// basic configuration
// --------------------

// you can let this send an e-mail to your for every added item
// just give it an e-mail address and a subject
define ("EMAIL", true);                               // (true/ false)
define ("EMAILTO", '');
define ("EMAILSUBJECT", 'here´s a new task for you');

// path to database
define ("DATABASE", 'database.json');

// define html head information, site title, site decsription and site keywords
define ("SITETITLE", 'webtasksystem');
define ("SITEDESC", '');
define ("SITEKEYS", '');
define ("SITEAUTHOR", 'Jannik Beyerstedt');
define ("SITEROBOTS", 'noindex, nofollow');

// set Title and subtitle of the page (top line of the page)
define ("UITITLE", 'Webtasks');
define ("UISUBTITLE", 'by Jannik Beyerstedt');

// display a custom alert
define ("ALERT_DISP", true);      // define if the alert is displayed
define ("ALERT_TYPE", 'warning'); // bootstrap types: success, info, warning, danger
define ("ALERT_TEXT", 'display some info or warning here');



// advanced config
// --------------------
define ("EMPTYTRASH", false);           // delete all trashed items (true/ false)
define ("SHOWDELETED", false);          // show deleted items in archive table (true/ false)

// enable adding users simply by logging in - DISABLE AFTER USE!!!
define ("ADDUSERS", false);             // (true/ false)

define ("PWBLOCKALL", false);           // show nothing without user login (true/ false)

// lookup-table for matching progress bars
define ("PROG_SCED", '10%');
define ("PROG_WORK", '30%');
define ("PROG_DONE", '100%');

?>