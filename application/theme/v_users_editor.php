<?/*
Шаблон редактора пользователей
==============================
$user['id_user']      идентификатор пльзователя
$user['username']     ник пользователя
$user['login']        логин
$user['description']  описание роли пользователя
*/?>

<table class="users-editor">
    <thead>
        <tr>
            <th>Имя пользователя
            <th>E-mail(login)
            <th>Роль
    </thead>
    <tbody>
<? foreach($users as $user): ?>
    <tr>
        <td><a href="<?=BASEURL,'UsersEditor/edit/',$user['id_user']?>"><?=$user['username']?></a></td>
        <td><?=$user['login']?></td>
        <td><?=$user['description']?></td>
    </tr>
<? endforeach; ?>
    </tbody>
</table>