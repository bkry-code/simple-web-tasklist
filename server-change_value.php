<?php
// -------------------------------------------
// webtasks/ bugtracker (by Jannik Beyerstedt)
// simple public task/ bug management system. Based on twitter bootstrap, php, jquery and a json database

// copyright: Jannik Beyerstedt | http://jannikbeyerstedt.de | code@jannikbeyerstedt.de
// license: http://www.gnu.org/licenses/gpl-3.0.txt GPLv3 License

// file: server-change_value.php - universal script to handle ajax POST to change a value
// version: 1.1 (2014-10-05)
// changelog: see readme.md
// -------------------------------------------


include 'config.php';
$filename = constant("DATABASE");

//echo 'hello you did' . var_dump($_POST["itemID"]) . ' to ' . var_dump($_POST['newState']);

if ( !empty($_POST['changeItem_ID']) ) {
  $itemID   = $_POST['changeItem_ID'];
  $field    = $_POST['changeItem_key'];
  $newValue = $_POST['changeItem_value'];
  
  if (!is_numeric($itemID)) { // item id not correct !
    echo "ERROR: item ID is not numeric";
  }
  
  // open file and decode json
  $file_content = file_get_contents($filename);
  $table_arr = json_decode($file_content, true);
  
  // manipulate item
  foreach ($table_arr as &$record) {
    if ( $record['id'] == $itemID ) { // if ID is found in database
      $record[$field] = $newValue;
      echo 'success';
      break;
    }
  }
  unset($record);
  
  
  // save array back to file
  $json_string = json_encode($table_arr,JSON_PRETTY_PRINT);

  if ( $json_string == FALSE ) {
    echo 'an unexpected error occurred saving your input to the database';
  }else {
    file_put_contents($filename,$json_string);
  }
  

}else {
  echo 'ERROR: no input';
}

?>