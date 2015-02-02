<?php
// Константы основных дерикторий сайта, префикс методов класса.
include_once('path.const.php');

// Языковые настройки, настройки временной зоны, запуск сессии,
// автозагрузка классов.
require APPPATH . 'startup.php';

// Префикс методов класса
$action = Core::GetConfig('settings', 'actionPrefix');

// Получить название метода класса из URL
$action .= (isset($_GET['act'])) ? $_GET['act'] : 'index';

// Получить название контроллера из URL
$c = isset($_GET['c']) ? $_GET['c'] : '' ;

// Создать экземпляр класса.
// При попытке создать экземпляр класса
// срабатывает __autoload и инклюдит файл,
// с именем такимже, как имя класса.
switch ($c)
{
	case 'editor':
		$controller = new C_Editor();
		break;
	default:
		$controller = new C_Page();
}

// Передать имя метода, который должен отработать у класса
// экземпляр которого только что был создан.
$controller->Request($action);
