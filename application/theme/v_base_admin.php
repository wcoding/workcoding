<?/*
Базовый шаблон для страниц админики
==================================================
$content - внутренний шаблон
$title - название сайта с описанием открытой страницы
*/?>

<!DOCTYPE html>
<html>
<head>
	<title><?=$title?></title>
	<meta content="text/html; charset=utf-8" http-equiv="content-type">	
	<link rel="stylesheet" type="text/css" media="screen" href="media/styles/admin.css">
</head>
<body>
<div class="wrapper">
	<h1><?=$title?></h1>
	<br>
	<a href="index.php">PHP. Уровень 2</a> |
	<a href="index.php?c=profile">Ваш профиль</a> |
	<a href="index.php?c=editor">Консоль редактора</a> |
	<a href="index.php?c=auth&act=logout">Выход</a>
	<hr>
<?=$content?>
	<hr>
</div>
</body>
</html>