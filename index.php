<?php
// -------------------------------------------
// webtasks/ bugtracker (by Jannik Beyerstedt)
// simple public task/ bug management system. Based on twitter bootstrap, php, jquery and a json database
// CC BY-NC-SA - Jannik Beyerstedt, jannikbeyerstedt.de, jtByt-Pictures@gmail.com

// file: index.php - draw the whole user interface (view only and editable version)
// version: 1.1.2 (2014-10-21)
// changelog: see readme.md
// -------------------------------------------

session_start();

$login_data = json_decode(file_get_contents('login.json'), true);

include 'config.php';
$filename = constant("DATABASE");

if (constant("ADDUSERS")) { 
  // add new users
  if (isset($_POST["username"]) && isset($_POST["password"])) {
    $username = $_POST["username"];
    $pw_hash = hash('sha256', $_POST["password"]);
    $login_data[$username] = $pw_hash;
    // save to file
    $json_string = json_encode($login_data,JSON_PRETTY_PRINT);
    file_put_contents("login.json",$json_string);
  }
}

if (isset($_POST["username"]) && isset($_POST["password"])) {
  foreach ($login_data as $user=>$pw_hash) {
    if ($user == $_POST["username"]) {
      $in_hash = hash('sha256', $_POST["password"]);
      if ($pw_hash == $in_hash) {
        $_SESSION["login"] = 1;
      }
    }
  }
}

if (constant("PWBLOCKALL")) {
  if ($_SESSION["login"] != 1) {
    include 'login.php';
    return;
  }
}

?>
<!DOCTYPE html>
<html lang="de">
  <head>
    <title><?php echo constant("SITETITLE") ?></title>
    <meta charset="utf-8" >
    <meta name="description" content="<?php echo constant("SITEDESC") ?>" >
    <meta name="keywords" content="<?php echo constant("SITEKEYS") ?>" >
    <meta name="author" content="<?php echo constant("SITEAUTHOR") ?>" >
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <meta name="robots" content="<?php echo constant("SITEROBOTS") ?>" >
    
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
    <link rel="apple-touch-icon" href="./apple-touch-icon-precomposed.png" />
    
    <link rel="stylesheet" href="./assets/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="./assets/style.css" />
  </head>

<body>
  <div class="container">
    
    <header>
      <div class="page-header">  
        <h1><span class="glyphicon glyphicon-tasks"></span> <?php echo constant("UITITLE") ?> <small><?php echo constant("UISUBTITLE") ?></small></h1>
      </div>
    </header>
    
    <?php
    if (constant("EMPTYTRASH")) {
      include 'empty_trash.php';
    }?>
    
    <?php if (constant("ALERT_DISP")) : ?>
    <div class="alert alert-<?php echo constant("ALERT_TYPE") ?>" role="alert"><?php echo constant("ALERT_TEXT") ?></div>
    <?php endif ?>
    
    <section class="input">
      <form role="form" class="form-inline" action="server-save_new_item.php" method="post">
        <div class="form-group">
          <label class="sr-only" for="inputTitle">Titel der Aufgabe</label>
          <input name="inputTitle" type="text" class="form-control" id="inputTitle" placeholder="Titel der Aufgabe" required="required">
        </div>
        <div class="form-group">
          <label class="sr-only" for="inputName">Dein Name</label>
          <input name="inputName" type="text" class="form-control" id="inputName" placeholder="Dein Name">
        </div>
        <div class="form-group">
          <label class="sr-only" for="inputDate">Datum fällig</label>
          <input name="inputDate" type="date" class="form-control" id="inputDate" placeholder="Datum: JJJJ-MM-DD">
        </div>
        <button type="submit" class="btn btn-primary">Absenden</button>
      </form>
    </section><!--end input-->

    <section class="data">
      
      <h3>alle Aufgaben:</h3>
      <table class="table table-striped table-condensed" id="mainTable">
        <thead>
        <tr>
          <th id="title">Titel</th>
          <th id="name">Name</th>
          <th id="date">geplant</th>
          <th id="state">Status</th>
        </tr>
        </thead>
        <tbody>
        <?php
          $table_arr = json_decode(file_get_contents($filename), true);
          foreach($table_arr as $row) {
            switch ($row['status']) {
              case 'in Arbeit':
                echo "          <tr class=\"warning\" id=\"row" . $row['id'] . "\"> \n";
                $progr_val = constant("PROG_WORK");
                $progr_col = 'progress-bar-warning';
                break;
              case 'geplant';
                echo "          <tr class=\"info\" id=\"row" . $row['id'] . "\"> \n";
                $progr_val = constant("PROG_SCED");
                $progr_col = 'progress-bar-info';
                break;
              case 'fertig';
                echo "          <tr class=\"success\" id=\"row" . $row['id'] . "\"> \n";
                $progr_val = constant("PROG_DONE");
                $progr_col = 'progress-bar-success';
                break;
              case 'Archiv';
                break;
              case 'trash';
                break;
              default:
                echo "          <tr id=\"row" . $row['id'] . "\"> \n";
                break;
            }
            if ($row['status'] != 'Archiv' && $row['status'] != 'trash') {
              foreach($row as $key=>$cell) {
                switch ($key) {
                  case 'id':
                    echo '';
                    break;
                  case 'title';
                    echo "            <td id=\"title\">";
                    //if ( !empty($row['progress']) ) {
                    if ( $row['status'] != 'eingereicht' ) {
                      if ( !empty($row['progress']) && ($row['progress'] != '100%') ) { // if manual value
                        $progr_val = $row['progress'];
                      }
                      
                      // if date is set, chech for overdue tasks. But not if task is done
                      if ( !empty($row['date']) && ($row['status'] != 'fertig') ) {
                        $date_due = strtotime($row['date']) + (24*60*60);
                        $current_date = time();
                        if ( time() > $date_due ) {
                          $progr_col = 'progress-bar-danger';
                        }
                      }
                      if ( empty($progr_col) ) { // if no color set
                        $progr_col = '';
                      }
                      echo "<div class=\"progress\">\n";
                      echo "              <div class=\"progress-bar " . $progr_col . "\" role=\"progressbar\" aria-valuenow=\"" . $progr_val . "\" aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width: " . $progr_val . ";\">\n";
                      echo "                <span class=\"sr-only\">" . $progr_val . " Complete</span></div>\n";
                      echo "              <p class=\"detail\" id=\"detail" . $row['id'] . "\">" . $cell . "</p>\n";
                      echo "            </div>";
                    }else {
                      echo "<p class=\"detail\" id=\"detail" . $row['id'] . "\">" . $cell . "</p>";
                    }
                    echo "</td>\n";
                    
                    unset($progr_val);
                    unset($progr_col);
                    
                    break;
                  case 'name';
                    echo "            <td id=\"name\">" . $cell . "</td>\n";
                    break;
                  case 'date';
                    if (empty($cell)) {$cell = 'no date';}
                    if ($_SESSION["login"] == 1) {
                      echo "            <td id=\"date\"><button class=\"btn btn-default btn-xs changeDate\" id=\"date" . $row['id'] . "\" data-toggle=\"popover\" >" . $cell . "</button></td>\n";
                    }else {
                      echo "            <td id=\"date\">" . $cell . "</td>\n";
                    }
                    break;
                  case 'status';
                    if ($_SESSION["login"] == 1) {
                      echo "            <td id=\"status\"> <button class=\"btn btn-default btn-xs changeState\" id=\"state" . $row['id'] . "\" data-toggle=\"popover\" >" . $cell . "</button></td>\n";
                    }else {
                      echo "            <td id=\"status\">" . $cell . "</td>\n";
                    }
                    break;
                  default:
                    //echo "          <tr> \n";
                    echo '';
                    break;
                }// end switch
              }
            }
            switch ($row['status']) {
              case 'Archiv';
                break;
              case 'trash';
                break;
              default:
                echo "          </tr> \n";
                break;
            }
          }
        ?>
        </tbody>

      </table>

    </section><!--end data-->

    <section class="archive">
      <h3>Archiv:</h3>
      <table class="table table-striped table-condensed" id="mainTable">
        <thead>
        <tr>
          <th id="title">Titel</th>
          <th id="name">Name</th>
          <th id="date">Datum</th>
          <th id="state">Status</th>
        </tr>
        </thead>
        <tbody>
        <?php
          foreach($table_arr as $row) {
            switch ($row['status']) {
              case 'Archiv':
                echo "          <tr id=\"row" . $row['id'] . "\"> \n";
                break;
              case 'trash':
                if (constant("SHOWDELETED")) {
                  echo "          <tr class=\"danger\" id=\"row" . $row['id'] . "\"> \n";
                }
                break;
              default:
                break;
            }
            //if ($row['status'] == 'Archiv' && $row['status'] != 'trash') {
            //if ($row['status'] == 'Archiv' || ( ($row['status'] == 'trash') && constant("SHOWDELETED") ) {
            if ($row['status'] == 'Archiv' || ($row['status'] == 'trash' && constant("SHOWDELETED")) ) {
              foreach($row as $key=>$cell) {
                switch ($key) {
                  case 'id':
                    echo '';
                    break;
                  case 'title';
                    echo "            <td id=\"title\"><p class=\"detail\" id=\"detail" . $row['id'] . "\">" . $cell . "</p></td>\n";
                    break;
                  case 'name';
                    echo "            <td id=\"name\">" . $cell . "</td>\n";
                    break;
                  case 'date';
                    if (empty($cell)) {$cell = 'no date';}
                    echo "            <td id=\"date\">" . $cell . "</td>\n";
                    break;
                  case 'status';
                    if ($_SESSION["login"] == 1) {
                      echo "            <td id=\"status\"> <button class=\"btn btn-default btn-xs changeState\" id=\"state" . $row['id'] . "\" data-toggle=\"popover\" >" . $cell . "</button></td>\n";
                    }else {
                      echo "            <td id=\"status\">" . $cell . "</td>\n";
                    }
                    break;
                  default:
                    echo "          <tr> \n";
                    break;
                }// end switch
              }
            }
            switch ($row['status']) {
              case 'Archiv':
                echo "          </tr> \n";
                break;
              case 'trash':
                if (constant("SHOWDELETED")) {
                  echo "          </tr> \n";
                }
                break;
              default:
                break;
            }
            
          }
        ?>
        </tbody>

      </table>
    </section>

  </div><!--end first container-->

  <div class="footer">
    <div class="container">
      <div class="text">
        <p class="text-muted">tasks/ bugtracker webapp (by Jannik Beyerstedt)</p>
      </div>
      <div class="login">
        <?php
        if ($_SESSION["login"] != 1) {
          echo '<a href="./login.php"><button type="button" class="btn btn-default btn-sm">Log in</button></a>';
        }else {
          echo '<button type="button" class="btn btn-default btn-sm" onclick="logout()">Log out</button>';
        }
        ?>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script src="./assets/bootstrap/js/bootstrap.min.js"></script>
  
  <!-- custom user interface an server communication scripts-->
  <?php if ($_SESSION["login"] == 1) :?>
  <script src="./assets/backendUI.js"></script>
  <?php else : ?>
  <script src="./assets/frontendUI.js"></script>
  <?php endif ?>
  
</body>
</html>