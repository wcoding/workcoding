<?php
//error_reporting(E_ALL | E_STRICT);

/* Процедура установки параметров, подключения к БД, запуска сессии.
*/
function startup() {
	// Настройки подключения к БД.
	$hostname = 'localhost'; 
	$username = 'root'; 
	$password = '';
	$dbName = 'school';
	
	// Языковая настройка.
	setlocale(LC_ALL, 'ru_RU.UTF-8'); // Устанавливаем нужную локаль (для дат, денег, запятых и пр.)
	mb_internal_encoding('UTF-8'); // Устанавливаем кодировку строк
	date_default_timezone_set('Europe/Moscow');
	
	// Подключение к БД.
	mysql_connect($hostname, $username, $password) or die('No connect with data base'); 
	// Установить кодировку по умолчанию для текущего соединения
	mysql_set_charset("SET NAMES utf8");
	// Выбрать БД, с которой будим работать.
	mysql_select_db($dbName) or die('No data base');

	// Открытие сессии.
	//session_start();
}

// Константа, где будет храниться путь до вьюшек
define('VIEW', '/theme/');