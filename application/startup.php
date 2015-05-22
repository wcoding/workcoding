<?php defined('SYSPATH') or die('No direct script access.');
// Подгрузить основной класс
require SYSPATH . 'classes/Core.php';

// Зарегистрировать функцию автозагрузки классов Core::autoLoad()
spl_autoload_register(array('Core', 'autoLoad'));
	
// Языковая настройка.
setlocale(LC_ALL, 'ru_RU.UTF-8'); // устанавливаем нужную локаль (для дат, денег, запятых и пр.)
mb_internal_encoding('UTF-8'); // устанавливаем кодировку строк
date_default_timezone_set('Europe/Moscow');

// Открытие сессии.
session_start();
