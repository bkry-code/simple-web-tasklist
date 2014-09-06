<?php
// -------------------------------------------
// webtasks/ bugtracker (by Jannik Beyerstedt)
// simple public task/ bug management system. Based on twitter bootstrap, php, jquery and a json database
// CC BY-NC-SA - Jannik Beyerstedt, jannikbeyerstedt.de, jtByt-Pictures@gmail.com

// file: empty_trash.php - deletes all items marked with trash from database
// version: 1.0 (2014-09-07)
// -------------------------------------------


include 'config.php';
$filename = constant("DATABASE");

// open file and decode json
$file_content = file_get_contents($filename);
$table_arr = json_decode($file_content, true);
  
// delete items
$i = 0;
foreach ($table_arr as $key=>$value) {
  if ( $value['status'] == 'trash' ) { // if marked as trash
    unset($table_arr[$key]);
    
    $i = $i+1;
  }
}
echo '<div class="alert alert-success" role="alert">housekeeping done - ' . $i . ' items removed from database</div>';
  
  
// save array back to file
$json_string = json_encode($table_arr,JSON_PRETTY_PRINT);

if ( $json_string == FALSE ) {
  echo '<div class="alert alert-danger" role="alert">an unexpected error occurred saving your input to the database</div>';
}else {
  file_put_contents($filename, $json_string);
}





?>
