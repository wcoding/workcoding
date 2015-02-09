<?/*
Шаблон регистрации нового пользователя
======================================
$message - сообщение валидации полей формы
$login - логин введённый пользователем
$username - имя введённое пользователем
*/?>

<? if(isset($message)): ?>
    <br>
    <b style="color: red;">Ошибка! </b><i style="color: red;"><?=$message;?></i>
<? endif; ?>
<br><br>
<form method="post" action="<?=BASEURL,'auth/register'?>">
    <label class="star">E-mail: </label>
    <br>
    <input type="text" name="login" value="<?=$login;?>">
    <br><br>
    <label class="star">Ваше имя: </label>
    <br>
    <input type="text" name="username" value="<?=$username;?>">
    <br><br>
    <label class="star">Пароль: </label><br>
    <input type="password" name="password" value="">
    <br><br>
    <label class="star">Повторите пароль: </label><br>
    <input type="password" name="confirm" value="">
    <br><br>
    <input type="submit" value="Ок">
    <br><br>
</form>