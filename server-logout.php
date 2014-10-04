<?php
// -------------------------------------------
// webtasks/ bugtracker (by Jannik Beyerstedt)
// simple public task/ bug management system. Based on twitter bootstrap, php, jquery and a json database
// CC BY-NC-SA - Jannik Beyerstedt, jannikbeyerstedt.de, jtByt-Pictures@gmail.com

// file: server-logout.php - does session logout
// version: 1.1 (2014-10-05)
// changelog: see readme.md
// -------------------------------------------


session_start();
session_destroy();
  
echo 'logout successful';
?>