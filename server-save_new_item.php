<?php
// -------------------------------------------
// webtasks/ bugtracker (by Jannik Beyerstedt)
// simple public task/ bug management system. Based on twitter bootstrap, php, jquery and a json database
// CC BY-NC-SA - Jannik Beyerstedt, jannikbeyerstedt.de, jtByt-Pictures@gmail.com

// file: server-save_new_item.php - gets submitted form (POST) an stores new value in database
// version: 1.1 (2014-10-05)
// changelog: see readme.md
// -------------------------------------------


if ( !empty($_POST['inputTitle']) ) {
  
  include 'config.php';
  $filename = constant("DATABASE");
  
  // create new item
  $new_item = array ('id'=>time(),
                     'title'  =>$_POST['inputTitle'],
                     'name'   =>$_POST['inputName'],
                     'date'   =>$_POST['inputDate'],
                     'status' =>'eingereicht',
                    );
  
  
  // open file and add item
  $file_content = file_get_contents('database.json');
  
  if ($file_content == FALSE ) { // do if file does not exist
    $table_arr = array($new_item);
    echo 'first item' . '<br>';
  }
  else { // append new item
    $table_arr = json_decode($file_content, true);
    $table_arr[] = $new_item;
    echo 'next item' . '<br>';
  }
  
  $json_string = json_encode($table_arr,JSON_PRETTY_PRINT);
  
  
  // safe file with new item
  if ( $json_string == FALSE ) {
    echo 'an unexpected error occurred saving your input to the database';
  }else {
    //echo var_dump($table_arr);
    file_put_contents("database.json",$json_string);
    header('Location: index.php');
  }
  
  // mail me the new item
  $recipient = constant("EMAILTO");
  $subject = constant("EMAILSUBJECT");
  $json_new_item = json_encode($new_item, JSON_PRETTY_PRINT);
  $message = "Hello You, here´s your bugtracker

someone submitted a new item to your list:

you will do: \t" . $_POST['inputTitle'] . "
due date: \t" . $_POST['inputDate'] . "
submitted by: \t" . $_POST['inputName'] . "


powered by your webserver";
  
  $mailreturn = mail ($recipient, $subject, $message);
  
  echo var_dump($mailreturn);

}else {
  echo 'no input';
}
?>