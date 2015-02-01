<?/*
Базовый шаблон для всех страниц
===============================
$content - внутренний шаблон
*/?>

<!DOCTYPE html>
<html>
<head>
	<title><?=$title?></title>
	<meta content="text/html; charset=utf-8" http-equiv="content-type">	
	<link rel="stylesheet" type="text/css" media="screen" href="media/styles/main.css"> 
</head>
<body>
<div class="wrapper">
	<h1><?=$title?></h1>
	<br>
	<a href="index.php">Главная</a> |
	<a href="index.php?c=editor">Консоль редактора</a>
	<hr>
<?=$content?>
	<hr>
	<small><a href="http://prog-school.ru">Школа Программирования</a> &copy;</small>
</div>
</body>
</html>