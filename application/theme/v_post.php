<?/*
Шаблон просмотра статьи
=======================
$article['title'] - заголовок
$article['content'] - содержание
$comment['name'] - имя комментатора
$comment['message'] - комментарий
*/?>

<h1><?=$article['title']?></h1>
<div><?=$article['content']?></div>

<hr>
<h4>Ваши комментарии.</h4>
<hr>

<? if( count($comments) > 0 ): ?>
    <? foreach($comments as $comment): ?>

        <div>
            <b><i><?=$comment['name']?></i>, пишет: </b><br>
            <p><?=$comment['message']?></p>
        </div>
        <hr>

    <? endforeach; ?>
<? endif; ?>

<br><br>

<a name="comments"></a>

<? if($error): ?>
    <b style="color: red;">Заполните все поля!</b>
<? endif; ?>

<form method="post" action="<?=BASEURL,'article/comments'?>">
    <label class="star">Привет! Как зовут тебя дружище? </label>
    <br>
    <input type="text" name="name" value="">
    <br><br>
    <label class="star">Напиши, что думаешь? </label><br>
    <textarea name="message"></textarea>
    <input type="hidden" name="id" value="<?=$article['id_article']?>">
    <br><br>
    <input type="submit" value="Опубликовать">
    <br><br>
</form>