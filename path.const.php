<?php
/** 
 * DIRECTORY_SEPARATOR
 */
define('DS', '/');

// Установить полный путь к корню сайта
define('DOCROOT', realpath(__DIR__) . DS);

$base_url = '/';

// Название папки с приложением
$application = 'application';

// Название папки с файлами фреймворка
$system = 'system';

define('BASEURL', $base_url);

if (! is_dir($application) and is_dir(DOCROOT . $application)) {
    $application = DOCROOT . $application;
}

// Путь до дерриктории с приложением
define('APPPATH', realpath($application) . DS);

// Путь до дерриктории с файлами фреймворка
define('SYSPATH', realpath($system) . DS);

// Удалить конфиг-е переменне
unset($application, $system, $base_url);

// Путь до вьюшек
define('VIEW', APPPATH . 'theme' . DS);

// Путь до контроллеров
define('CONTROLLER', APPPATH . 'classes' . DS . 'controller' . DS);
define('CONTROLLER_ADMIN', APPPATH . 'classes' . DS . 'controller' . DS . 'admin' . DS);
define('CONTROLLER_PUBLICLY', APPPATH . 'classes' . DS . 'controller' . DS . 'publicly' . DS);

// Путь до моделей
define('MODEL', APPPATH . 'classes' . DS . 'model' . DS);

// Соль для паролей
define('SALTPASS', "fg08908 d*k9dd0;d^00 &$#@~!3");
