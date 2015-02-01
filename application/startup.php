<?php
	
// Языковая настройка.
setlocale(LC_ALL, 'ru_RU.UTF-8'); // устанавливаем нужную локаль (для дат, денег, запятых и пр.)
mb_internal_encoding('UTF-8'); // устанавливаем кодировку строк
date_default_timezone_set('Europe/Moscow');

// Открытие сессии.
# session_start();



/**
 * Функция автозагрузки файла вкотором описан класс,
 * экземпляр которого мы пытаемся создать.
 *
 * @param string $classname имя файла котрый нужно подключить
 * @return void
 */
 function __autoload($classname){
	
	 if( file_exists(CONTROLLER."$classname.php") )
		 include_once(CONTROLLER."$classname.php");
						
	 if( file_exists(MODEL."$classname.php") )
		 include_once(MODEL."$classname.php");
 }