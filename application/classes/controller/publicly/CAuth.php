<?php 

namespace Classes\Controller\Publicly;

use Classes\Controller\CBasePublicly;

/**
 * Контроллер авторизации
 */
class CAuth extends CBasePublicly
{
    /**
     * Авторизация пользователя
     */
    public function actionLogin()
    {
        // Флаг ошибки
        $error = false;

        // Если пользователь нажал кнопку "Войти"
        if ($this->isPost()) {
            $auth = $this->mUsers->login(
                $_POST['login'], 
                $_POST['password'], 
                isset($_POST['remember'])
            );
            
            // Если авторизация произошла, перенаправить на страницу профиля
            if (true === $auth) {
                $this->redirect('/profile');
            }
            
            $error = true;
        }

        // Название страницы
        $this->title .= ' :: Авторизация';

        // Подготовить внутренний шаблон страницы для передачи его в базовый шаблон
        $this->content = $this->getHtml('v_login.php', array('error' => $error));
    }


    /**
     * Выход
     */
    public function actionLogout()
    {
        $this->mUsers->logout();
        $this->redirect();
    }


    /**
     * Регистрация нового пользователя
     */
    public function actionRegister()
    {
        // Если пользователь нажал кнопку
        if ($this->isPost()) {
            // Если поля "Пароль" и "Повторить пароль" совпадают
            if ($_POST['password'] == $_POST['confirm']) {
                // зарегистрировать пользователя
                $result = $this->mUsers->add(
                    $_POST['login'], 
                    $_POST['password'], 
                    $_POST['username'], 
                    5
                );
                // Проверить, какой результат
                if (is_integer($result)) {
                    // если регистрация прошла успешно
                    if ($result > 0) {
                        // авторизовать пользователя и отправить в профиль
                        $this->mUsers->login($_POST['login'], $_POST['password']);
                        $this->redirect('/profile');
                    }

                    $message = 'Такой пользователь уже существует.';
                } else {
                    $message = 'Заполните поля формы.';
                }
                
            } else {
                $message = 'Поля "Пароль" и "Повторить пароль" не совпадают.';
            }

            // запомнить введённые пользователем данные
            // в случае ошибки
            $login = $_POST['login'];
            $username = $_POST['username'];
            
        // если только пришли
        } else {
            $login = '';
            $username = '';
        }

        // Название страницы
        $this->title .= ' :: Зарегистрироваться';

        // Подготовить внутренний шаблон страницы для передачи его в базовый шаблон
        $this->content = $this->getHtml(
            'v_register.php',
            array(
                'login' => $login, // введённый пользователем логин
                'username' => $username, // введённый пользователем ник
                'message' => $message // сообщение
            )
        );
    }
}
