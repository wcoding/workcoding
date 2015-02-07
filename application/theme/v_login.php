<?/*
Шаблон авторизации
=======================

*/?>

<? if($error): ?>
    <b style="color: red;">Ошибка! Неверные логин или пароль.</b>
<? endif; ?>

<form method="post" action="index.php?c=auth&act=login">
    <label class="star">Логин: </label>
    <br>
    <input type="text" name="login" value="">
    <br><br>
    <label class="star">Пароль: </label><br>
    <input type="password" name="password" value="">
    <br><br>
    <label><input type="checkbox" name="remember"> Запомить меня</label>
    <br><br>
    <input type="submit" value="Войти"> | <a href="index.php?c=auth&act=register">Регистрация</a>
</form>
<br>