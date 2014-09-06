<?php
// -------------------------------------------
// webtasks/ bugtracker (by Jannik Beyerstedt)
// simple public task/ bug management system. Based on twitter bootstrap, php, jquery and a json database
// CC BY-NC-SA - Jannik Beyerstedt, jannikbeyerstedt.de, jtByt-Pictures@gmail.com

// file: server-logout.php - does session logout
// version: 0.1 (2014-09-06)
// -------------------------------------------


session_start();
session_destroy();
  
echo 'logout successful';
?>