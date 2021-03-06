// -------------------------------------------
// webtasks/ bugtracker (by Jannik Beyerstedt)
// simple public task/ bug management system. Based on twitter bootstrap, php, jquery and a json database

// copyright: Jannik Beyerstedt | http://jannikbeyerstedt.de | code@jannikbeyerstedt.de
// license: http://www.gnu.org/licenses/gpl-3.0.txt GPLv3 License

// file: backendUI.js - generates UI-Elements and does server communication for backend (login)
// version: 1.1 (2014-10-05)
// changelog: see readme.md
// -------------------------------------------



// generate popovers for each .changeState button
// --------------------
$('.changeState').each(function() { // do for each button
  var id = this.id.replace('state','');

  var popSubm  = '<button class="btn btn-default btn-xs btn-block" onclick="changeVal(\''+id+'\',\'status\',\'eingereicht\')">start</button>';
  var popSched = '<button class="btn btn-primary btn-xs btn-block" onclick="changeVal(\''+id+'\',\'status\',\'geplant\')">scheduled</button>';
  var popProgr = '<button class="btn btn-warning btn-xs btn-block" onclick="changeVal(\''+id+'\',\'status\',\'in Arbeit\')">progress</button>';
  var popDone  = '<button class="btn btn-success btn-xs btn-block" onclick="changeVal(\''+id+'\',\'status\',\'fertig\')">done</button>';
  var popArch  = '<button class="btn btn-default btn-xs btn-block" onclick="changeVal(\''+id+'\',\'status\',\'Archiv\')">archive</button>';
  var popTrash = '<button class="btn btn-danger btn-xs btn-block" onclick="changeVal(\''+id+'\',\'status\',\'trash\')">trash</button>';

  $('#state'+id).popover({trigger:'manual', // focus
                     html:true, 
                     placement: 'top',
                     content: popSubm+popSched+popProgr+popDone+popArch+popTrash })

  
  $('#state'+id).click(function(){
    hideAllPopovers(this);
    $('#state'+id).popover('show')
  })
} ) // end each popover state change


// generate popovers for each .changeDate button
// --------------------
$('.changeDate').each(function() { // do for each button
  var id = this.id.replace('date','');
  
  var dateForm = '<form name="dateForm'+id+'" role="form" ><div class="form-group">';
  var datePicr = '<input name="dateFormInput'+id+'" type="date" class="form-control changeDate" id="datePicker'+id+'"></input></div>';
  var dateSubm = '<div class="dateButtons"><button onclick="changeDate('+id+')" name="dateFormSubmit'+id+'" type="button" class="btn btn-primary btn-sm" id="dateSubmit'+id+'">ändern</button> ';
  var dateDel  = '<button onclick="changeDate('+id+',\'del\')" name="dateFormSubmit'+id+'" type="button" class="btn btn-warning btn-sm" id="dateSubmit'+id+'">löschen</button> ';
  var dateCncl = '<button onclick="$(\'#date'+id+'\').popover(\'hide\')" name="dateFormSubmit'+id+'" type="button" class="btn btn-default btn-sm" id="dateSubmit'+id+'">abbrechen</button>';
  var dateEnd  = '</div></form>';

  $('#date'+id).popover({trigger:'manual',
                     html:true,
                     placement: 'top',
                     content: dateForm+datePicr+dateSubm+dateDel+dateCncl+dateEnd })
  
  $('#date'+id).click(function(){
    hideAllPopovers(this);
    $('#date'+id).popover('show');
  })

} ) // end each popover date change


// close popovers before another popover is openend
// give it the this pointer, can´t figure out how it works otherwise
// --------------------
function hideAllPopovers (elem) {
  $('.changeState').not(elem).each(function() {
    var id = this.id.replace('state','');
    $('#state'+id).popover('hide');
  });
  $('.changeDate').not(elem).each(function() {
    var id = this.id.replace('date','');
    $('#date'+id).popover('hide');
  });
//  $('.detail').not(elem).each(function() {
//    var id = this.id.replace('detail','');
//    $('p.detail#detail'+id).popover('hide');
//  });
}


// prepare date data to be send to server (get date value, make a blank date, etc.)
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
  }else {
    console.log('change: '+id+' to: '+date);
  }
  
  changeVal(id, 'date', date);
}


// generate popovers for each title column cell text
// --------------------
$('tbody').children('tr').on('click','p', function(e) {
  var id = this.id.replace('detail','');
  
  console.log('detail popover triggered: '+id);
  
  var getRequest = {getItem_ID: id};
  var currentText = '';
  $.ajax({
    type: "POST",
    url: "server-get_detail.php",
    data: getRequest,
    cache: false,
    success:  function(data){
      if (data.substr(0, 5).toLowerCase() != 'error') {
        if (data !== '') { // if not empty
          currentText = data;
          $('#detailText'+id).val(currentText);
          //$('#detailText'+id).height( $('#detailText'+id)[0].scrollHeight );
        }else {
          $('#detailText'+id).val('no details');
          console.log('detail empty');
        }
      }else {
        alert(data);
      }
    }
  });
  
  var detailInit = '<form name="detailForm'+id+'" role="form" class="detailForm" ><div class="form-group">';
  
  var detTitleTx = '<input  name="titleFormInput'+id+'" type="text" class="form-control changeTitle" id="titleText'+id+'"></input>';
  
  var detailTFld = '<textarea  name="detailFormInput'+id+'" type="textarea" class="form-control changeDetail" id="detailText'+id+'"></textarea></div>';
  var detailSubm = '<div class="detailButtons form-inline"> <button onclick="changeDetail('+id+')" type="button" class="btn btn-primary btn-sm" id="detailSubmit'+id+'">ändern</button> ';
  var detailCncl = '<button onclick="detailPop_Hide(\''+id+'\')" type="button" class="btn btn-default btn-sm" id="detailCancel'+id+'">schließen</button>';
  
  var detProgPre = '    <div class="input-group input-group-sm" id="progress"><span class="input-group-addon">progress</span>';
  var detProgSet = '<input name="detailProgressInput'+id+'" type="number" min="0" max="100" step="10" class="form-control changeProgress" id="detailProgress'+id+'"></input>';
  var detProgPst = '<span class="input-group-addon">%</span></div>';
  var detProgRst = ' <button onclick="detailProg_rst(\''+id+'\')" type="button" class="btn btn-default btn-sm" id="detailCancel'+id+'">auto progress</button>';
  
  var detailEnd  = '<div></form>';
  
  var detProgAll = detProgPre + detProgSet + detProgPst + detProgRst;
  var detTskTitl = detTitleTx;
  
  $('p.detail#detail'+id).popover({trigger:'manual',
                     html:true, 
                     placement: 'top',
                     content: detailInit+detTskTitl+detailTFld+detailSubm+detailCncl+detProgAll+detailEnd})
  
  hideAllPopovers(this);
  $('p.detail#detail'+id).popover('show');
  
  // set title text field to current value
  var titleVal = $(this).text();
  $('#titleText'+id).val(titleVal);
  
  // display current progress % in the input field
  var progrVal = $(this).parent().children('div.progress-bar').attr('aria-valuenow');
  if (progrVal !== undefined ) {
    progrVal = progrVal.substr(0,2);
    $('#detailProgress'+id).val(progrVal);
  }
})

// hide popover on clicking cancel
// --------------------
function detailPop_Hide (id) {
  $('p.detail#detail'+id).popover('hide');
  console.log('detail popover hidden');
}

// reset progress value
// --------------------
function detailProg_rst (id) {
  console.log('detail progress reset');
  
  changeVal(id, 'progress', ''); // set empty string
}


// prepare text to be send to server
// --------------------
function changeDetail (id) {
  $('p.detail#detail'+id).popover('hide');
  
  var detail = $('#detailText'+id).val();
  if (detail == 'no details') {
    detail = '';
  }
  changeVal(id, 'detail', detail);
  
  var progress = $('#detailProgress'+id).val() + '%';
  if ( progress != '%' ) {
    changeVal(id, 'progress', progress);
  }
  
  var title = $('#titleText'+id).val();
  if ( title.trim() ) { // if text is not empty or blanks
    changeVal(id, 'title', title);
  }
}


// sends change request to server
// --------------------
function changeVal (itemID, itemKey, itemVal) {
  console.log('change: '+itemID+' key: '+itemKey+' to: '+itemVal);
  
  var changeRequest = {changeItem_ID: itemID, changeItem_key: itemKey , changeItem_value: itemVal};
  console.log(changeRequest);
  
  $.ajax({
    type: "POST",
    url: "server-change_value.php",
    data: changeRequest,
    cache: false,
    success:  function(data){
      if (data != 'success') {
        alert(data);
      }
      window.location.reload(true);
    }
  });
}


// function for logout button
// --------------------
function logout () {
  console.log('logout');
  
  $.post('server-logout.php',function(data){
      if (data != 'logout successful') {
        alert(data);
      }
      window.location.reload(true);
    } );
}