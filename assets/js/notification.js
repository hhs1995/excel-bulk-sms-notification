/**
 * @Author: Ketan Velip
 * @Date:   2015-09-08 11:28:07
 * @Last Modified by:   ketanvelip
 * @Last Modified time: 2016-10-22 13:24:52
 */


/*================ Send Notification (Form) ===================*/
function sendNotification(id) {
  

  /* phone */
  if($('#phone').val()=='')
  {
    $('#error-phone').text('Please select a field');
    
    return false;
  }
  else
  {
    $('#error-phone').text('');
  }


  /* subtitle */
  if($('#subtitle').val()=='')
  {
    $('#error-subtitle').text('Please enter a subtitle');
    
    return false;
  }
  else
  {
    $('#error-subtitle').text('');
  }


  /* message */
  if($('#message').val()=='')
  {
    $('#error-message').text('Please enter message to be sent');
    
    return false;
  }
  else
  {
    $('#error-message').text('');
  }



  $('#sn-add-button').hide();
  $('#add-sn-spinner').show();
  $('#add-sn-msg').hide();
  var fd = new FormData();
  fd.append('phone', $('#phone').val());
  fd.append('message', $('#message').val());
  fd.append('upload-path', $('#upload-path').val());
  fd.append("form", id); 
  
  $.ajax({
    url: 'assets/controller/NotificationController.php',
    type: 'POST',
    data: fd,
    enctype: 'multipart/form-data',
    processData: false,  // tell jQuery not to process the data
    contentType: false,
  })
  .done(function(res) {
    if(res==1){
      $('#add-sn-spinner').hide();
      $('#add-sn-msg').show();
      $('#add-sn-msg').fadeOut(500, function(){
          $('#add-sn-msg').hide();
          $('#sn-add-button').show();
          // $('#add-sn-form')[0].reset();
      });
    } else {
      $('#add-sn-msg').hide();
      $('#add-sn-spinner').hide();
      $('#sn-add-button').show();    
      alert('Notifications not sent');
    }
  })
  .fail(function() {
    //console.log("error");
  });
}
