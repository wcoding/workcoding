<?/*
Шаблон страницы "профиль пользователя"
======================================
$message - сообщение валидации полей формы
$user['name'] ник пользователя
*/?>
<br>
<ul>
<? if($can): ?>
    <li><a href="index.php?c=editor">Консоль редактора</a></li>
<? endif; ?>

    <li><a href="index.php?c=auth&act=logout">Выйти</a></li>
</ul>

<? if(isset($message)): ?>
    <br>
    <b style="color: red;">Ошибка! </b><i style="color: red;"><?=$message;?></i>
<? endif; ?>

<h3>Редактировать профиль.</h3>

<form method="post">
    <label>Ваше имя: </label>
    <br>
    <input type="text" name="username" value="<?=$user['name'];?>">
    <br><br>
    <label>Новый пароль: </label><br>
    <input type="password" name="password" value="">
    <br><br>
    <label>Повторите пароль: </label><br>
    <input type="password" name="confirm" value="">
    <br><br>
    <input type="submit" value="Сохранить">
    <br><br>
</form>