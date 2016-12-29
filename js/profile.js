$(document).ready(function () {
  $('#saveProfileBtn').click(function () {
    var s_url = '/application/helpers/actions.php';

    $.ajax({
      url: s_url,
      method: "POST",
      data:{
        action:'profileUpdate',
        name:$('#name').val(),
        surname:$('#surname').val(),
        secondname:$('#secondname').val(),
        telephone:$('#telephone').val(),
        interests:$('#profile-interests-ta').val(),
        email:$('#email').val()
      },
      success:function (response) {
        // alert(response);
      },
      error:function (response) {
        // alert('error');
      }
    });
  });
});
