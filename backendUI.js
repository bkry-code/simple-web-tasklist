// -------------------------------------------
// webtasks/ bugtracker (by Jannik Beyerstedt)
// simple public task/ bug management system. Based on twitter bootstrap, php, jquery and a json database
// CC BY-NC-SA - Jannik Beyerstedt, jannikbeyerstedt.de, jtByt-Pictures@gmail.com

// file: backendUI.js - generates UI-Elements and does server communication for backend (login)
// version: 0.1 (2014-09-06)
// -------------------------------------------


// generate popovers for each .changeState button
// --------------------
$('.changeState').each(function() { // do for each button
  var idStr = this.id;
  var id = idStr.replace('state','');

  var popSubm  = '<button class="btn btn-default btn-xs btn-block" onclick="changeVal(\''+id+'\',\'status\',\'eingereicht\')">start</button>';
  var popSched = '<button class="btn btn-primary btn-xs btn-block" onclick="changeVal(\''+id+'\',\'status\',\'geplant\')">scheduled</button>';
  var popProgr = '<button class="btn btn-warning btn-xs btn-block" onclick="changeVal(\''+id+'\',\'status\',\'in Arbeit\')">progress</button>';
  var popDone  = '<button class="btn btn-success btn-xs btn-block" onclick="changeVal(\''+id+'\',\'status\',\'fertig\')">done</button>';
  var popArch  = '<button class="btn btn-default btn-xs btn-block" onclick="changeVal(\''+id+'\',\'status\',\'Archiv\')">archive</button>';
  var popTrash = '<button class="btn btn-danger btn-xs btn-block" onclick="changeVal(\''+id+'\',\'status\',\'trash\')">trash</button>';

  $('#state'+id).popover({trigger:'click',
                     html:true, 
                     placement: 'top',
                     content: popSubm+popSched+popProgr+popDone+popArch+popTrash })
} ) // end each popover state change


// sends change request to server
// --------------------
function changeVal (itemID, itemKey, itemVal) {
  console.log('TRIGGERED');
  console.log('change: '+itemID+' key: '+itemKey+' to: '+itemVal);
  
  var changeRequest = {changeItem_ID: itemID, changeItem_key: itemKey , changeItem_value: itemVal};
  console.log(changeRequest);
  
  $.ajax({
    type: "POST",
    url: "server-change_value.php",
    data: changeRequest,
    cache: false,
    success:  function(data){
      //alert("---"+data);
      if (data != 'success') {
        alert(data);
      }
      window.location.reload(true);
    }
  });
}



// generate popovers for each .changeDate button
// --------------------
$('.changeDate').each(function() { // do for each button
  var idStr = this.id;
  var id = idStr.replace('date','');
  
  var dateForm = '<form name="dateForm'+id+'" role="form" ><div class="form-group">';
  var datePicr = '<input name="dateFormInput'+id+'" type="date" class="form-control changeDate" id="datePicker'+id+'"></input></div>';
  var dateSubm = '<div class="dateButtons"><button onclick="changeDate('+id+')" name="dateFormSubmit'+id+'" type="button" class="btn btn-primary btn-sm" id="dateSubmit'+id+'">ändern</button> ';
  var dateDel  = '<button onclick="changeDate('+id+',\'del\')" name="dateFormSubmit'+id+'" type="button" class="btn btn-warning btn-sm" id="dateSubmit'+id+'">löschen</button> ';
  var dateCncl = '<button onclick="$(\'#date'+id+'\').popover(\'hide\')" name="dateFormSubmit'+id+'" type="button" class="btn btn-default btn-sm" id="dateSubmit'+id+'">abbrechen</button>';
  var dateEnd  = '</div></form>';

  $('#date'+id).popover({trigger:'manual',
                     html:true,
                     placement: 'top',
                     content: dateForm+datePicr+dateSubm+dateDel+dateCncl+dateEnd });
  
  $('#date'+id).click(function(){
    $('#date'+id).popover('show')
  });
  
  $('.popover-content').click(function(){
    $('#date'+id).popover('hide')
  });

} ) // end each popover date change


// send new date to server: {itemID: $int, newState: $string }
// --------------------
function changeDate(id, opt) {
  $('#date'+id).popover('hide');
  
  var date = $('#datePicker'+id).val();
  if (opt == 'del'){
    console.log('change: '+id+' --> delete date');
    date = '';
  }else if (date.length==0) {
    console.log('change: '+id+' --> empty date value');
    return;
  }
  console.log('change: '+id+' to: '+date);
  
  changeVal(id, 'date', date);
}








function logout () {
  console.log('logout');
  
  $.post('server-logout.php',function(data){
      //alert("---"+data);
      if (data != 'logout successful') {
        alert(data);
      }
      window.location.reload(true);
    } );
}