<?/*
Шаблон добавления статьи
=======================
$title - название статьи
$content - содержание
*/?>
<? if($error) :?>
	<b style="color: red;">Заполните все поля!</b>
<? endif ?>
<form method="post">
	Название:
	<br>
	<input type="text" name="title" value="<?=$title?>">
	<br>
	<br>
	Содержание:
	<br>
	<textarea name="content"><?=$content?></textarea>
	<br>
	<input type="submit" value="Добавить">
</form>