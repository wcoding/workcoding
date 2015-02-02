<?php

/*  | E_STRICT */
# error_reporting(E_ALL & ~E_DEPRECATED);

// Установить полный путь к корню сайта
define('DOCROOT', realpath(__DIR__).DIRECTORY_SEPARATOR);

// Название папки с приложением
$application = 'application';

// Название папки с файлами фреймворка
$system = 'system';

if ( ! is_dir($application) AND is_dir(DOCROOT.$application))
    $application = DOCROOT.$application;

// Путь до дерриктории с приложением
define('APPPATH', realpath($application).DIRECTORY_SEPARATOR);

// Путь до дерриктории с файлами фреймворка
define('SYSPATH', realpath($system).DIRECTORY_SEPARATOR);

// Удалить конфиг-ю переменную
unset($application, $system);

// Путь до вьюшек
define('VIEW', APPPATH.'theme'.DIRECTORY_SEPARATOR);

// Путь до контроллеров
define('CONTROLLER', APPPATH.'classes'.DIRECTORY_SEPARATOR.'controller'.DIRECTORY_SEPARATOR);

// Путь до моделей
define('MODEL', APPPATH.'classes'.DIRECTORY_SEPARATOR.'model'.DIRECTORY_SEPARATOR);
