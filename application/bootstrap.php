<?php
//подключаем файлы ядра
require_once 'core/model.php';
require_once 'core/view.php';
require_once 'core/controller.php';
//подключаем файл с классом маршрутизатора и запускаем на выполнение
require_once 'core/route.php';

/*
Здесь обычно подключаются дополнительные модули, реализующие различный функционал:
	> аутентификацию
	> кеширование
	> работу с формами
	> абстракции для доступа к данным
	> ORM
	> Unit тестирование
	> Benchmarking
	> Работу с изображениями
	> Backup
	> и др.
*/

require_once 'modules/transformation.php';
require_once 'vendor/ubench-master/src/Ubench.php';

Route::start();
//маршрутизатор (по идее) превращает строки браузера в ЧПУ (человекоподобные урл)
?>
