function setTelephone(input) {
    $('#current-telephone').find('span').html(input);
}

$(document).ready(function () {

    $('#signInModalBtn').click(function () {
        $('#request').modal();
    });

    $('.telephone-btn').click(function () {
        setTelephone($(this).html());
    });
});
