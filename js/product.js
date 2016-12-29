var url = '../application/helpers/actions.php';

function addFavorite() {
    $.post({
        url: url,
        data: {
            action: 'addFavorite'
        }
    }).done(function (response) {
        if (response == 'true') {

        }
        if (response == 'false') {

        }
        if (response == 'login_error') {

        }
    }).fail(function (xhr, str) {
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

function removeFavorite() {

}

function setRaiting() {

}

function addFeedback() {

}

function removeFeedback() {

}

function buy() {

}

function compare() {

}

function makeSearchJson(type) {
    switch (type) {
        case 'fulltext':
            var searchJson = {
                SearchType : type,
                action : "",
                search : $('#searchInp').val()
            }
            return searchJson;
            break;
        case 'filter':
            var searchJson = {
                minimum_price: $('.min-price-select').attr('data-min-price'),
                maximum_price: $('.max-price-select').attr('data-max-price'),
                Product_category: $('#search_category').text(),
                ProducerName: [],
                cSchema_Name: [],
                cValueValue: [],
                action: "",
                SearchType: ""
            }

            $('.searchSlideBlock').each(function (i) {
                $(this).find('input').each(function (j) {
                    if ($(this).prop('checked')) {
                        if ($(this).attr('data-schema') == 'ProducerName') {
                            searchJson['ProducerName'].push($(this).attr('data-value'));
                        } else {
                            searchJson['cSchema_Name'].push($(this).attr('data-schema'));
                            searchJson['cValueValue'].push($(this).attr('data-value'));
                        }
                    }
                });
            });

            searchJson['SearchCategory'] = $('#search_category').text();

            return searchJson;
            break;
        default:
            return false;
            break;
    }

}

function goSearch(type) {
    var searchCondition = makeSearchJson(type);
    searchCondition['action'] = 'makeSearch';
    searchCondition['SearchType'] = type;
    console.log(searchCondition);
    $.post({
        url: url,
        data: searchCondition
    }).done(function (response) {
        console.log(response);
        setTimeout(function () {
            $(location).attr('href', '/Search');
        }, 100);
    }).fail(function (xhr, str) {
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

$(document).ready(function () {
    $('#submitProdSearchBtn').click(function () {
        goSearch('filter');
        return false;
    });

    $('#searchBtn').click(function () {
        goSearch('fulltext');
        return false;
    })

    $('.similar-product_sub_pages-carousel').owlCarousel({
        items: 3,
        loop: false
    });

    $('.searchSlideBtn').click(function () {
        if ($(this).parent().find('.searchSlideBlock').is(":visible")) {
            console.log($(this));
            $(this).find('span').find('i').css('transform', 'rotate(-90deg)');
        } else {
            $(this).find('span').find('i').css('transform', 'rotate(0deg)');
        }

        $(this).parent().find('.searchSlideBlock').slideToggle("fast");
        return false;
    });

    $('.carousel-img').owlCarousel({
        loop: false,
        nav: false,
        items: 4,
        margin: 10
    });

    var min = $('#min-price').data('min');
    var max = $('#max-price').data('max');

    $('#price-slider').slider({
        range: true,
        min: min,
        max: max,
        values: [min, max],
        slide: function (event, ui) {
            min = ui.values[0];
            max = ui.values[1];
            $('.min-price-select').attr("data-min-price", min);
            $('.max-price-select').attr("data-max-price", max);
            $('.min-price-select').text(ui.values[0] + " грн - ");
            $('.max-price-select').text(ui.values[1] + " грн");
        },
        classes: {
            "ui-slider-handle": "slider-points",
            "ui-slider-range": "slider-value"
        }
    });


});