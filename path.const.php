<?php

// Установить полный путь к корню сайта
define('DOCROOT', realpath(__DIR__).DIRECTORY_SEPARATOR);

$base_url = '/';

// Название папки с приложением
$application = 'application';

// Название папки с файлами фреймворка
$system = 'system';

define('BASEURL', $base_url);

if ( ! is_dir($application) AND is_dir(DOCROOT.$application))
    $application = DOCROOT.$application;

// Путь до дерриктории с приложением
define('APPPATH', realpath($application).DIRECTORY_SEPARATOR);

// Путь до дерриктории с файлами фреймворка
define('SYSPATH', realpath($system).DIRECTORY_SEPARATOR);

// Удалить конфиг-е переменне
unset($application, $system, $base_url);

// Путь до вьюшек
define('VIEW', APPPATH.'theme'.DIRECTORY_SEPARATOR);

// Путь до контроллеров
define('CONTROLLER', APPPATH.'classes'.DIRECTORY_SEPARATOR.'controller'.DIRECTORY_SEPARATOR);
define('CONTROLLER_ADMIN', APPPATH.'classes'.DIRECTORY_SEPARATOR.'controller'.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR);
define('CONTROLLER_PUBLICLY', APPPATH.'classes'.DIRECTORY_SEPARATOR.'controller'.DIRECTORY_SEPARATOR.'publicly'.DIRECTORY_SEPARATOR);

// Путь до моделей
define('MODEL', APPPATH.'classes'.DIRECTORY_SEPARATOR.'model'.DIRECTORY_SEPARATOR);

// Соль для паролей
define('SALTPASS', "fg08908 d*k9dd0;d^00 &$#@~!3");
