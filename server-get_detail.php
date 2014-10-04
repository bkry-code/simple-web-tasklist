<?php
// -------------------------------------------
// webtasks/ bugtracker (by Jannik Beyerstedt)
// simple public task/ bug management system. Based on twitter bootstrap, php, jquery and a json database
// CC BY-NC-SA - Jannik Beyerstedt, jannikbeyerstedt.de, jtByt-Pictures@gmail.com

// file: server-get_detail.php - specific script for delivering detail information
// version: 1.1 (2014-10-05)
// changelog: see readme.md
// -------------------------------------------


include 'config.php';
$filename = constant("DATABASE");

//echo 'hello you did' . var_dump($_POST["itemID"]) . ' to ' . var_dump($_POST['newState']);

if ( !empty($_POST['getItem_ID']) ) {
  $itemID   = $_POST['getItem_ID'];
  $field    = 'detail';
  
  if (!is_numeric($itemID)) { // item id not correct !
    echo 'ERROR: item ID is not numeric';
  }
  
  // open file and decode json
  $file_content = file_get_contents($filename);
  $table_arr = json_decode($file_content, true);
  
  // get items detail field
  foreach ($table_arr as &$record) {
    if ( $record['id'] == $itemID ) { // if ID is found in database
      $detail = $record[$field];
      echo $detail;
      break;
    }
  }
  unset($record);
  
  unset($table_arr);

}else {
  echo 'ERROR: no input';
}

?>