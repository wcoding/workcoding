<?/*
Базовый шаблон для всех страниц публичной части сайта
=====================================================
$content - внутренний шаблон
$title - название сайта с описанием открытой страницы
*/?>
<!DOCTYPE html>
<html>
<head>
	<title><?=$title?></title>
	<meta content="text/html; charset=utf-8" http-equiv="content-type">	
	<link rel="stylesheet" type="text/css" media="screen" href="<?=BASEURL.'media/styles/main.css'?>">
</head>
<body>
<div class="wrapper">
	<h1><?=$title?></h1>
	<br>
	<a href="<?=BASEURL?>">Главная</a> |
	<a href="<?=BASEURL,'profile'?>">Ваш профиль</a>
	<hr>
<?=$content?>
	<hr>
	<small>
		<b>Друзя сайта: </b>
		<a href="http://prog-school.ru">Школа Программирования</a>
		 | 
		<a href="http://geekbrains.ru">GeekBrains</a>
	</small>
</div>
</body>
</html>