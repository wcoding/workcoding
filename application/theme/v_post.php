<?/*
Шаблон просмотра статьи
=======================
$article['title'] - заголовок
$article['content'] - содержание
$comment['name'] - имя комментатора
$comment['message'] - комментарий
$user - массив данных о пользователе
($user !== null) - пользователь авторизирован
*/?>

<h1><?=$article['title']?></h1>
<div><?=$article['content']?></div>

<hr>
<h4>Комментарии.</h4>
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

<? if( 0 !== count($user) ): ?>

<? if($error): ?>
    <b style="color: red;">Заполните все поля!</b>
<? endif; ?>

<form method="post" action="<?=BASEURL,'article/comments'?>">
    <label class="star">Напиши, что думаешь? </label><br>
    <textarea name="message"></textarea>
    <input type="hidden" name="id" value="<?=$article['id_article']?>">
    <br><br>
    <input type="submit" value="Опубликовать">
    <br><br>
</form>

<? else: ?>

<b style="color: green;"><a href="<?=BASEURL,'auth/login'?>">Войти</a>, чтобы оставить комментарий.</b>

<? endif; ?>