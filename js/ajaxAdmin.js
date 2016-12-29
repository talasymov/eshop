$(document).ready(function () {
  $('.adminTab').click(function () {
    var toLoad = $(this).attr('href');
    // alert(toLoad);
    // function loadContent() {
      $('#admin-content').load(toLoad, '');
    // }

    return false;

  });

  $('#admin-content').find('#test').click(function () {
    alert($('#male-radio').val());
    alert($('#female-radio').val());
    $.ajax({
      url: "/application/helpers/actions.php",
      method: "POST",
      data:{
        action:'adminSearch',
        name:$('#name').val(),
        surname:$('#surname').val(),
        secondname:$('#secondname').val(),

      }
    });

  });

});
