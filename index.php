<?php
/*  | E_STRICT, & ~E_NOTICE & ~E_DEPRECATED  */
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

// Константы основных дерикторий сайта, соль для паролей.
include_once('path.const.php');

// Языковые настройки, настройки временной зоны, запуск сессии,
// автозагрузка классов.
require APPPATH . 'startup.php';

// Префикс методов класса, из конфига
$action = WorkCoding\Core::getConfig('settings', 'actionPrefix');

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
$action .= isset($params['action']) ? ucfirst($params['action']) : 'Index';

// Получить название контроллера из URL
$c = isset($params['controller']) ? $params['controller'] : '' ;

// Создать экземпляр класса.
// При попытке создать экземпляр класса
// срабатывает Core::auto_load() и инклюдит файл,
// с именем такимже, как имя класса.
switch ($c) {
    case 'editor':
        $controller = new Classes\Controller\Admin\CAdminPanel;
        break;
    case 'ArticlesEditor':
        $controller = new Classes\Controller\Admin\CArticlesEditor;
        break;
    case 'CommentsEditor':
        $controller = new Classes\Controller\Admin\CCommentsEditor;
        break;
    case 'UsersEditor':
        $controller = new Classes\Controller\Admin\CUsersEditor;
        break;
    case 'PagesEditor':
        $controller = new Classes\Controller\Admin\CPagesEditor;
        break;
    case 'auth':
        $controller = new Classes\Controller\Publicly\CAuth;
        break;
    case 'profile':
        $controller = new Classes\Controller\Publicly\CUserPanel;
        break;
    case 'article':
        $controller = new Classes\Controller\Publicly\CArticle;
        break;
    case 'page':
        $controller = new Classes\Controller\Publicly\CPages;
        break;
    case '':
        $controller = new Classes\Controller\Publicly\CIndex;
        break;
    default:
        // От бесконечных дублей главной страницы
        header("HTTP/1.0 404 Not Found");
        include(VIEW . '404.php');
        exit;
}

// Передать имя метода, который должен отработать у класса
// экземпляр которого только что был создан.
$controller->request($action, $params);
