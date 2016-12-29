<?php
//включаем вывод ошибок
ini_set('display_errors',1);
//фильтруем ошибки по важности в зависимости от версии php (E_STRICT появился в php v5).
if (version_compare(phpversion(), "5.0.0", ">")==1) {
	ini_set("error_reporting", E_ALL | E_STRICT);
} else {
	ini_set("error_reporting", E_ALL);
};
//подключаем файл, который инициирует загрузку приложения, подключая все необходимые модули
require_once 'application/bootstrap.php';
 ?>
