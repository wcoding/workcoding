<?php
/*  | E_STRICT, & ~E_NOTICE & ~E_DEPRECATED  */
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

// Константы основных дерикторий сайта, соль для паролей.
include_once('path.const.php');

// Языковые настройки, настройки временной зоны, запуск сессии,
// автозагрузка классов.
require APPPATH . 'startup.php';

// Префикс методов класса, из конфига
$action = Core::getConfig('settings', 'actionPrefix');

$info = explode('/', $_GET['q']);
$params = array();

for ($i=0; $i <= count($info); $i++) {
    if ($info[$i] != '') {

        if ($i == 0) {
            $params['controller'] = $info[$i];
            continue;
        }

        if ($i == 1) {
            $params['action'] = $info[$i];
            continue;
        }

        $params[] = $info[$i];
    }
}

// Получить название метода класса из URL
$action .= isset($params['action']) ? $params['action'] : 'index';

// Получить название контроллера из URL
$c = isset($params['controller']) ? $params['controller'] : '' ;

// Создать экземпляр класса.
// При попытке создать экземпляр класса
// срабатывает Core::auto_load() и инклюдит файл,
// с именем такимже, как имя класса.
switch ($c) {
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
    case 'auth':
        $controller = new C_Auth;
        break;
    case 'profile':
        $controller = new C_UserPanel;
        break;
    case 'article':
        $controller = new C_Article;
        break;
    case 'page':
        $controller = new C_Pages;
        break;
    case '':
        $controller = new C_Index;
        break;
    default:
        // От бесконечных дублей главной страницы
        header("HTTP/1.0 404 Not Found");
        include(VIEW.'404.php');
        exit;
}

// Передать имя метода, который должен отработать у класса
// экземпляр которого только что был создан.
$controller->Request($action, $params);
