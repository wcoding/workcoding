<?php
/**
 * Контроллер авторизации
 */

class C_Auth extends C_BasePublicly
{

    /**
     * Авторизация пользователя
     */
    public function action_login()
    {
        // Флаг ошибки
        $error = false;

        // Если пользователь нажал кнопку "Войти"
        if($this->IsPost()){

            // Если авторизация произошла, перенаправить на страницу профиля
            if ( $this->mUsers->Login( $_POST['login'], $_POST['password'], isset($_POST['remember']) ) )
            {
                $this->Redirect('/profile');
            }

            $error = true;
        }


        // Название страницы
        $this->title .= ' :: Авторизация';

        // Подготовить внутренний шаблон страницы для передачи его в базовый шаблон
        $this->content = $this->GetHtml('v_login.php', array('error' => $error) );
    }



    /**
     * Выход
     */
    public function action_logout()
    {
        $this->mUsers->Logout();
        $this->Redirect();
    }



    /**
     * Регистрация нового пользователя
     */
    public function action_register()
    {
        // Если пользователь нажал кнопку
        if($this->IsPost()){

            // Если поля "Пароль" и "Повторить пароль" совпадают
            if($_POST['password'] == $_POST['confirm']){

                // зарегистрировать пользователя
                $result = $this->mUsers->Add($_POST['login'], $_POST['password'], $_POST['username'], 5);

                // Проверить, какой результат
                if ( is_integer($result) ){

                    // если регистрация прошла успешно
                    if($result > 0){

                        // авторизовать пользователя и отправить в профиль
                        $this->mUsers->Login( $_POST['login'], $_POST['password']);
                        $this->Redirect('/profile');
                    }

                    $message = 'Такой пользователь уже существует.';
                }
                else{
                    $message = 'Заполните поля формы.';
                }
            }
            else{
                $message = 'Поля "Пароль" и "Повторить пароль" не совпадают.';
            }

            // запомнить введённые пользователем данные
            // в случае ошибки
            $login = $_POST['login'];
            $username = $_POST['username'];
        }
        // если только пришли
        else{
            $login = '';
            $username = '';
        }


        // Название страницы
        $this->title .= ' :: Зарегистрироваться';

        // Подготовить внутренний шаблон страницы для передачи его в базовый шаблон
        $this->content = $this->GetHtml(
            'v_register.php',
            array(
                'login' => $login, // введённый пользователем логин
                'username' => $username, // введённый пользователем ник
                'message' => $message // сообщение
            )
        );
    }
}