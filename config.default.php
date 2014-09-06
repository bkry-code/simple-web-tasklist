<?php
// -------------------------------------------
// webtasks/ bugtracker (by Jannik Beyerstedt)
// simple public task/ bug management system. Based on twitter bootstrap, php, jquery and a json database
// CC BY-NC-SA - Jannik Beyerstedt, jannikbeyerstedt.de, jtByt-Pictures@gmail.com

// file: config.php - config values and switches
// version: 0.1 (2014-09-06)
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
define ("UITITLE", 'webtasks');
define ("UISUBTITLE", 'Jannik Beyerstedt');



// advanced config
// --------------------


define ("EMPTYTRASH", false);           // delete all trashed items (true/ false)

// enable adding users simply by logging in - DISABLE AFTER USE!!!
define ("ADDUSERS", false);             // (true/ false)

// implement!
define ("SHOWDELETED", false);          // show another table with deleted items (true/ false)

// implement!
define ("PWBLOCKALL", false);           // show nothing without user login (true/ false)
  

?>