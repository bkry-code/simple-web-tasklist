<?php
// -------------------------------------------
// webtasks/ bugtracker (by Jannik Beyerstedt)
// simple public task/ bug management system. Based on twitter bootstrap, php, jquery and a json database

// copyright: Jannik Beyerstedt | http://jannikbeyerstedt.de | code@jannikbeyerstedt.de
// license: http://www.gnu.org/licenses/gpl-3.0.txt GPLv3 License

// file: server-logout.php - does session logout
// version: 1.1 (2014-10-05)
// changelog: see readme.md
// -------------------------------------------


session_start();
session_destroy();
  
echo 'logout successful';
?>