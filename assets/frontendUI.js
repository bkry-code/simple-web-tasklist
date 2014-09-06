// -------------------------------------------
// webtasks/ bugtracker (by Jannik Beyerstedt)
// simple public task/ bug management system. Based on twitter bootstrap, php, jquery and a json database
// CC BY-NC-SA - Jannik Beyerstedt, jannikbeyerstedt.de, jtByt-Pictures@gmail.com

// file: frontendUI.php - generates UI elements only used in frontend (no edit functions)
// version: 1.0 (2014-09-07)
// -------------------------------------------


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
    async: false,
    data: getRequest,
    cache: false,
    success:  function(data){
      if (data.substr(0, 4) != 'ERROR') {
        if (data !== '') { // if not empty
          currentText = data;
        }else {
          currentText = 'no details';
          console.log('detail empty');
        }
      }else {
        alert(data);
      }
    }
  });
  
  //var detailInit = '<div class="detailText"><p id="detailText'+id+'">';
  //var detailDef  = '(leer)</p></div>';
  var detailInit = '<div class="detailText" id="detailText'+id+'">';
  var detailDef  = ' .</div>';
  var detailCncl = '<div class="detailButtons"> <button onclick="detailPop_Hide(\''+id+'\')" type="button" class="btn btn-default btn-xs" id="detailCancel'+id+'">schließen</button>';
  var detailEnd  = '<div>';
  
  $('p.detail#detail'+id).popover({trigger:'manual',
                     html:true, 
                     placement: 'top',
                     content: detailInit+detailDef+detailCncl+detailEnd})
  
  $('p.detail#detail'+id).popover('show')
  $('#detailText'+id).text(currentText)
  
  if (currentText == 'no details') {
    setTimeout(function(){
      detailPop_Hide(id);
    },1000);
  }
})

// hide popover on clicking cancel
// --------------------
function detailPop_Hide (id) {
  $('p.detail#detail'+id).popover('hide');
  console.log('detail popover hidden');
}