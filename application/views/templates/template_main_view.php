<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content=""/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>

    <link rel="shortcut icon" href="favicon.png"/>

    <title>Главная</title>
    <link rel="stylesheet" href="/libs/bootstrap/bootstrap.min.css"/>
    <link rel="stylesheet" href="/libs/datepicker/css/bootstrap-datetimepicker.min.css"/>
    <link rel="stylesheet" href="/libs/OwlCarousel2-2.2.0/dist/assets/owl.carousel.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.3/css/base/jquery.ui.all.css" rel="stylesheet">
    <link href="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.2/css/lightness/jquery-ui-1.10.2.custom.min.css"
          rel="stylesheet">
    <link rel="stylesheet" href="/css/main.css" media="screen" title="no title" charset="utf-8">

    <script src="/libs/jquery/jquery-3.1.0.min.js" charset="utf-8"></script>
    <script type="text/javascript" src="/libs/datepicker/js/moment-with-locales.min.js"></script>
    <script type="text/javascript" src="/libs/bootstrap/bootstrap.min.js"></script>
    <script type="text/javascript" src="/libs/datepicker/js/bootstrap-datetimepicker.min.js"></script>
    <script src="/libs/noty/js/jquery.noty.packaged.min.js"></script>
    <script src="/libs/OwlCarousel2-2.2.0/dist/owl.carousel.min.js"></script>
    <script
        src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
        integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
        crossorigin="anonymous"></script>
    <script src="/libs/rangeSlider/rangeSlider.js"></script>

    <script src="/js/main.js" charset="utf-8"></script>
    <script src="/js/authorization.js" charset="utf-8"></script>
    <script src="/js/admin.js" charset="utf-8"></script>
    <script src="/js/profile.js" charset="utf-8"></script>
    <script src="/js/product.js"></script>

</head>
<body>
<div class="modal fade bs-example-modal-md" id="signInModal" tabindex="-1" role="dialog"
     aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3>Вход в систему</h3>
            </div>
            <div class="modal-body">
                <form action="">
                    <label for="login">Введите логин: </label><input type="text" name="login" id="login"
                                                                     required="required"></br>
                    <label for="password">Введите пароль: </label><input type="password" name="password" id="password"
                                                                         required="required"></br>
                    <input type="submit" value="Войти" id="signInUserBtn"> <input type="button" data-dismiss="modal"
                                                                                  value="Отмена">
                    <a href="javascript:void(0);">Забыли пароль?</a> <a
                        href="javascript:void(0);">Зарегистрироваться</a>
                </form>
            </div>
        </div>
    </div>
</div>
<header id="header">
    <div class="container-fluid">
        <div class="row top-panel">
            <div class="col-md-2"><a href="http://champ.in.ua/"><img src="/img/logo.png"></a></div>
            <div class="col-md-8">
                <nav class="link-panel">
                    <a href="/Delivery">
                        <div class="top-panel-link">
                            <p>Доставка и оплата</p>
                        </div>
                    </a>
                    <a href="/Faq">
                        <div class="top-panel-link">
                            <p>Вопросы и ответы</p>
                        </div>
                    </a>
                    <a href="/Contacts">
                        <div class="top-panel-link">
                            <p>Контакты</p>
                        </div>
                    </a>
                    <a href="http://champ.in.ua/">
                        <div class="top-panel-link">
                            <p>Перейти в рекламное агенство</p>
                        </div>
                    </a>
                </nav>
                <div class="col-md-12">
                    <div class="search">
                        <input type="text" id="searchInp" placeholder="Что будем искать?">
                        <button id="searchBtn"><i class="fa fa-search" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <!--                <div class="telephone">-->
                <!--                    --><?php
                //                    $telephones = explode(',', $data['ShopData'][0]['Telephones']);
                //                    ?>
                <!--                    <button class="dropdown-toggle" type="button" data-toggle="dropdown" id="current-telephone">-->
                <!--                        <span>-->
                <!--                            --><?php
                //                            echo $telephones[0];
                //                            ?>
                <!--                        </span>-->
                <!--                    </button>-->
                <!--                    <ul class="dropdown-menu telephone-data">-->
                <!--                        --><?php
                //                        foreach ($telephones as $item) {
                //                            printf("<li><a class=\"telephone-btn\">%s</a></li>", $item);
                //                        }
                //                        ?>
                <!--                    </ul>-->
            </div>
            <div class="user-link-header">
                <div class="trash"></div>
                <div class="account"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-md-offset-8 text-right in-out_links">
                <?php
                if (!isset($_SESSION['isUserCorrect'])) {
                    $_SESSION['isUserCorrect'] = FALSE;
                }

                if ($_SESSION['isUserCorrect']) {
                    print('<a href="/Profile">Мой профиль</a> / ');
                    print('<a href="" id="userExitBtn">Выйти</a>');
                } else {
                    print('<a href="" data-toggle="modal" data-target="#signInModal" id="signInModalBtn">Войти</a> / ');
                    print('<a href="/SignUp">Зарегистрироваться</a>');
                }
                ?>
            </div>
        </div>
    </div>
</header>

<?php include 'application/views/' . $content_view; ?>

<footer id="footer">

</footer>
</body>
</html>
