
// Duyanmic form submit 
$(document).on('submit', '.ajax_form_submit', function(event){
  var form = this;
  event.preventDefault();
    var surl = $(this).attr("action");
    var formData = new FormData(this);
    $.ajax({
      type: 'POST',
      url: surl,
      contentType: false,
      cache: false,
      processData:false,
      data: formData,
      beforeSend: function(){
        $(form).find(':submit').html($(form).find(':submit').text()+'<i class="fa fa-spinner fa-spin ml-1"></i>');  
      },
      success: function(response){
        // console.log(response);
        response = JSON.parse(response);
        alert(response.message);
        if(response.status != 'false'){
           window.location.href = response.reloadUrl;
        } 
      },
      error: function(response){
        // console.log(response);
        response = JSON.parse(response);
        alert(response.message);
        window.location.href = response.reloadUrl;
      }
    });
    
});
