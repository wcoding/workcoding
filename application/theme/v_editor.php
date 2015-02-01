<?/*
Шаблон редактируемой страницы
=======================
$articles - список статей

статья:
id_article - идентификатор
title - заголвок
content - текст
*/?>
<ul>
	<li>
		<b><a href="index.php?c=editor&act=add">Новая статья</a></b>
	</li>
</ul>
<table>
<? foreach ($articles as $article): ?>
	<tr>
		<td>
			<a href="index.php?c=editor&act=edit&id=<?=$article['id_article']?>">
				<?=$article['title']?>
			</a>
		<td>
			<a href="index.php?c=editor&act=edit&id=<?=$article['id_article']?>&delete">
				<span style="color:red;">Удалить</span>
			</a>
<? endforeach; ?>
</table>
