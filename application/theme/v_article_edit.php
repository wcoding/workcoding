<?/*
Шаблон редактирования статьи
=======================
$article['id_article'] - идентификатор статьи
$article['title'] - заголовок
$article['content'] - содержание
*/?>
<? if($error) :?>
	<b style="color: red;">Заполните все поля!</b>
<? endif ?>
<form method="post">
	Название:
	<br>
	<input type="text" name="title" value="<?=$article['title']?>">
	<br>
	<br>
	Содержание:
	<br>
	<textarea name="content"><?=$article['content']?></textarea>
	<br>
	<input type="hidden" name="id" value="<?=$article['id_article']?>">
	<input type="submit" value="Сохранить">
</form>