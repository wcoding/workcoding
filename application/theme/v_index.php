<?/*
Шаблон главной страницы блога
=============================
$article['id_article'] - идентификатор статьи
$article['title'] - заголовок
$article['content'] - содержание
*/?>
<?foreach($articles as $article):?>

	<h1>
		<a href="<?=BASEURL,'article/index/',$article['id_article']?>"><?=$article['title']?></a>
	</h1>
	<p><?=$article['intro']?></p>
	<hr>

<? endforeach; ?>