<?phpinclude_once('startup.php');include_once('model.php');// Установка параметров, подключение к БД, запуск сессии.startup();// Подготовить внутренний шаблон страницы для передачи его в базовый шаблон$v_editor = get_html( 'v_editor.php', array('articles' => articles_all()) );// Подставить в базовый шаблон сайта, шаблон конкретной страницы// и вывести всё на экранecho get_html( 'v_base.php', array('content' => $v_editor) );