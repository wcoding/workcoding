<?php

/*  | E_STRICT, & ~E_NOTICE & ~E_DEPRECATED  */
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

// Константы основных дерикторий сайта, соль для паролей.
include_once('path.const.php');

// Языковые настройки, настройки временной зоны, запуск сессии,
// автозагрузка классов.
require APPPATH . 'startup.php';

// Префикс методов класса, из конфига
$action = Core::GetConfig('settings', 'actionPrefix');

// Получить название метода класса из URL
$action .= (isset($_GET['act'])) ? $_GET['act'] : 'index';

// Получить название контроллера из URL
$c = isset($_GET['c']) ? $_GET['c'] : '' ;

// Создать экземпляр класса.
// При попытке создать экземпляр класса
// срабатывает Core::auto_load() и инклюдит файл,
// с именем такимже, как имя класса.
switch ($c)
{
	case 'editor':
		$controller = new C_AdminPanel;
		break;
	case 'ArticlesEditor':
		$controller = new C_ArticlesEditor;
		break;
	case 'CommentsEditor':
		$controller = new C_CommentsEditor;
		break;
	case 'UsersEditor':
		$controller = new C_UsersEditor;
		break;
	case 'PagesEditor':
		$controller = new C_PagesEditor;
		break;
	case 'profile':
		$controller = new C_UserPanel;
		break;
	case 'page':
		$controller = new C_Pages;
		break;
	case 'auth':
		$controller = new C_Auth;
		break;
	default:
		$controller = new C_Articles;
}

// Передать имя метода, который должен отработать у класса
// экземпляр которого только что был создан.
$controller->Request($action);
