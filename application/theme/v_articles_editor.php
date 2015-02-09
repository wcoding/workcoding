<?/*
Шаблон страницы редактира статей
================================
$articles - список статей

статья:
id_article - идентификатор
title - заголвок
content - текст
*/?>
<ul>
	<li>
		<b><a href="<?=BASEURL,'ArticlesEditor/add'?>">Новая статья</a></b>
	</li>
</ul>
<table>
<? foreach ($articles as $article): ?>
	<tr>
		<td>
			<a href="<?=BASEURL,'ArticlesEditor/edit/',$article['id_article']?>">
				<?=$article['title']?>
			</a>
		<td>
			<a href="<?=BASEURL,'ArticlesEditor/edit/',$article['id_article'],'/delete'?>">
				<span style="color:red;">Удалить</span>
			</a>
<? endforeach; ?>
</table>
