<?/*
Шаблон страницы редактирование данных пользователя
==================================================
$message - сообщение валидации полей формы

$user['name'] ник пользователя
$user['login'] логин
$user['id_role'] идентификатор роли пользователя

$role['name'] название роли
$role['id_role'] идентификатор роли
*/?>

<p><a href="<?=BASEURL,'UsersEditor'?>">Редактор пользователей</a></p>

<? if(isset($message)): ?>
    <br>
    <b style="color: red;">Ошибка! </b><i style="color: red;"><?=$message;?></i>
<? endif; ?>

<form method="post">
    <input type="hidden" name="userID" value="<?=$user['id_user']?>">
    <label>Имя пользователя: </label>
    <br>
    <input type="text" name="username" value="<?=$user['name'];?>">
    <br><br>
    <label>login: </label><br>
    <input type="text" value="<?=$user['login'];?>" disabled="disabled">
    <br><br>
    <label>Роль: </label><br>
    <select name="role">

<? foreach($roles as $role): ?>

    <? if( $role['id_role'] == $user['id_role'] ): ?>

        <option value="<?=$user['id_role'];?>" selected><?=$role['name'];?></option>
    <? continue; ?>
    <? endif; ?>

        <option value="<?=$role['id_role'];?>"><?=$role['name'];?></option>

<? endforeach; ?>

    </select>
     |
    <input type="submit" value="Сохранить">
    <br><br>
</form>