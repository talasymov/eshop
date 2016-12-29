var action_url = '../application/helpers/actions.php';

function authAdmin() {
    var data = $('#signIn_form').serializeArray();
    data.push({name: "action", value: "signInAdmin"});
    console.log(data);
    $.post({url: action_url, data: data, dataType: "json"})
        .done(function (response) {
            if (response == 'true') {
                noty({
                    text: "Авторизация прошла успешно!<br>Через 3 секунды Вы будете перенаправлены...",
                    type: 'information',
                    dismissQueue: true,
                    layout: 'topCenter',
                    theme: 'defaultTheme'
                });
                setTimeout(function () {
                    location.href = '/Admin/Main';
                }, 3000);
            } else {
                noty({
                    text: "Неправильный логин или пароль!<br>Попробуйте еще раз, или обратитесь к системному администратору!",
                    type: 'error',
                    dismissQueue: true,
                    layout: 'topCenter',
                    theme: 'defaultTheme'
                });
            }
        })
        .fail(function (xhr, str) {
            noty({
                text: "Что-то пошло не так! Попробуйте через некоторое время!",
                type: 'error',
                dismissQueue: true,
                layout: 'topCenter',
                theme: 'defaultTheme'
            });
            console.error('Что-то не так при отправке формы - ' + xhr.responseCode + ' ' + str);
        });
}

function exitAdmin() {
    $.post({
        url: action_url,
        dataType: "json",
        data: {action: "signOutAdmin"}
    })
        .done(function () {
            $(location).attr('href', '/Admin/');
        })
        .fail(function (xhr, str) {
            noty({
                text: "Что-то пошло не так! Попробуйте через некоторое время!",
                type: 'error',
                dismissQueue: true,
                layout: 'topCenter',
                theme: 'defaultTheme'
            });
            console.error("Неполадки с функцией выхода - " + xhr.responseCode + ' ' + str);
        });
}

function authUser() {
    $.post({
        url: action_url,
        data: {
            action: 'signIn',
            login: $('#login').val(),
            password: $('#password').val()
        },
    })
        .done(function (response) {
            console.log(response);
            var result = JSON.parse(response);
            if (result === 'redirect') {
                location.reload(true);
            }
            if (result === 'true') {
                noty({
                    text: "Авторизация прошла успешно!",
                    type: 'information',
                    dismissQueue: true,
                    layout: 'topCenter',
                    theme: 'defaultTheme'
                });
                setTimeout(function () {
                    location.reload(true);
                }, 1700);
            }
            if (result === 'false') {
                noty({
                    text: "Неверное имя пользователя или пароль! Попробуйте еще раз!",
                    type: 'error',
                    dismissQueue: true,
                    layout: 'topCenter',
                    theme: 'defaultTheme'
                });
            }
        })
        .fail(function (xhr, str) {
            noty({
                text: "Что-то пошло не так! Попробуйте через некоторое время!",
                type: 'error',
                dismissQueue: true,
                layout: 'topCenter',
                theme: 'defaultTheme'
            });
            console.error('Что-то не так при отправке формы - ' + xhr.responseCode + ' ' + str);
        });
}

function exitUser() {
    $.post({
        url: action_url,
        data: {action: "signOut"}
    })
        .done(function (response) {
            setTimeout(function () {
                location.reload(true);
            }, 1000);
        })
        .fail(function (xhr, str) {
            noty({
                text: "Что-то пошло не так! Попробуйте через некоторое время!",
                type: 'error',
                dismissQueue: true,
                layout: 'topCenter',
                theme: 'defaultTheme'
            });
            console.error("Проблемы при выходе пользователя - " + xhr.responseCode + ' ' + str);
            return false;
        });
}

function maleClick() {
    $('#male').addClass('choiced');
    if ($('#female').hasClass('choiced'))$('#female').removeClass('choiced');
}

function femaleClick() {
    $('#female').addClass('choiced');
    if ($('#male').hasClass('choiced'))$('#male').removeClass('choiced');
}

function getGender() {
    return $('#male').hasClass('choiced') ? 'Мужской' : 'Женский';
}

function isNullOrWhitespace(input) {
    return !input || !input.trim();
}

function isStringNotExists(input) {
    return input.indexOf('@', 1) < 0;
}

function isStrNonEqual(str1, str2) {
    return str1 !== str2;
}

function isStrLengthLowerThen(str, length) {
    return str.length < length;
}

function errorTransform(selector) {
    $(selector).addClass('errorInputAnimation');
    //clear input
    $(selector).find('input').val('');
    //delete class when clicked input
    $(selector).find('input').click(function () {
        $(selector).removeClass('errorInputAnimation');
    });
}

function validateForm() {
    var isValid = true;
    if (isNullOrWhitespace($('#sign_up_user_login').val())) {
        errorTransform('.login');
        isValid = false;
    }
    if (isNullOrWhitespace($('#sign_up_user_name').val())) {
        errorTransform('.name');
        isValid = false;
    }
    if (isNullOrWhitespace($('#sign_up_user_surname').val())) {
        errorTransform('.surname');
        isValid = false;
    }
    if (isNullOrWhitespace($('#sign_up_user_email').val()) || isStringNotExists($('#sign_up_user_email').val())) {
        errorTransform('.email');
        isValid = false;
    }
    if (isNullOrWhitespace($('#sign_up_user_password').val())
        || isStrLengthLowerThen($('#sign_up_user_password').val(), 8)
        || isStrNonEqual($('#sign_up_user_password').val(), $('#sign_up_user_password_confirm').val())) {
        errorTransform(".password");
        isValid = false;
    }

    if (isNullOrWhitespace($('#sign_up_user_password_confirm').val())
        || isStrLengthLowerThen($('#sign_up_user_password_confirm').val(), 8)
        || isStrNonEqual($('#sign_up_user_password').val(), $('#sign_up_user_password_confirm').val())) {
        errorTransform(".password_confirm");
        isValid = false;
    }
    return isValid;
}

function signUp() {
    if (validateForm()) {
        $.post({
            url: action_url,
            dataType: 'json',
            data: {
                action: 'signUp',
                //user_data
                login: $('#sign_up_user_login').val(),
                name: $('#sign_up_user_name').val(),
                email: $('#sign_up_user_email').val(),
                password: $('#sign_up_user_password').val(),
                surname: $('#sign_up_user_surname').val(),
                patronymic: $('#sign_up_user_patronymic').val(),
                gender: getGender(),
                telephone: $('#sign_up_user_telephone').val(),
                birthdate: $('#sign_up_user_birthdate').val(),
                //user_address
                country: $('#sign_up_user_country').val(),
                state: $('#sign_up_user_state').val(),
                region: $('#sign_up_user_region').val(),
                city: $('#sign_up_user_city').val(),
                street: $('#sign_up_user_street').val(),
                buildNumber: $('#sign_up_user_buildNumber').val(),
                porch: $('#sign_up_user_porch').val(),
                apartment: $('#sign_up_user_apartment').val(),
                cityIndex: $('#sign_up_user_cityIndex').val()
            }
        }).done(function (response) {
            if (response == true) {
                noty({
                    text: "Регистрация прошла успешно!",
                    type: 'information',
                    dismissQueue: true,
                    layout: 'topCenter',
                    theme: 'defaultTheme'
                });
                setTimeout(function () {
                    history.back();
                }, 2500);
            }
            if (response == 'login exists') {
                noty({
                    text: "Login уже занят! Попробуйте другой!",
                    type: 'error',
                    dismissQueue: true,
                    layout: 'topCenter',
                    theme: 'defaultTheme'
                });
            }
            console.log(response);
        })
            .fail(function (xhr, str) {
                noty({
                    text: "Что-то пошло не так! Попробуйте через некоторое время!",
                    type: 'error',
                    dismissQueue: true,
                    layout: 'topCenter',
                    theme: 'defaultTheme'
                });
                console.error("Неполадки с функцией реестрации! " + xhr.responseCode + ' ' + str);
            });
    }
}

$(document).ready(function () {

    $('#sign_up_user_birthdate').datetimepicker({
        language: 'ru',
        pickTime: false
    });

    $('#signInBtn').click(function () {
        authAdmin();
        return false;
    });

    $('#AdminExit').click(function () {
        exitAdmin();
        return false;
    });

    $('#signInUserBtn').click(function () {
        authUser();
        return false;
    });

    $('#userExitBtn').click(function () {
        exitUser();
        return false;
    });

    $('#female').click(function () {
        femaleClick();
    });

    $('#male').click(function () {
        maleClick();
    });

    $('#signUpUserBtn').click(function () {
        signUp();
    });

    $('#cancelBtn').click(function () {
        history.back();
    });
});
