<?php
/**
 * Контроллер страницы профиля, зарегестрированного пользователя
 */

class C_UserPanel extends C_BasePublicly
{
    private $can; // Флаг на доступ в админку


    /**
     * Метод подготавливает данные, которые будут использоваться
     * в методе action_*
     */
    protected function before()
    {
        parent::before();

        // Очистка старых сессий.
        $this->mUsers->ClearSessions();

        // Если пользователь не зарегистрирован - отправляем на страницу регистрации.
        if ($this->mUsers->Get() == null) {
            $this->Redirect('/auth/login');
        }

        // Если пользователь получил ban, дать отлуп
        if ($this->mUsers->Can('NO_ACCESS')) {
            $this->Redirect('/auth/logout');
        }

        $this->can = false;

        // проверить право доступа в админку
        if ( ! $this->mUsers->Can('USER'))
            $this->can = true;

        $this->title = 'Профиль пользователя';
    }


    /**
     * Экшн страницы профиля
     */
    public function action_index()
    {

        if($this->IsPost()){

            // Поля равны и в том случае, если пользователь их не заполнял
            if($_POST['password'] == $_POST['confirm']){

                // обновить данные о пользователе
                $result = $this->mUsers->Change($_POST['username'], $_POST['password']);

                // Если неудача, значит на данный момент пользователь уже не авторизован
                if ( FALSE === $result ){
                    $this->Redirect('/auth/login');
                }
            }
            else{
                $message = 'Поля "Пароль" и "Повторить пароль" не совпадают.';
            }

        }

        // Передать имя пользователя в заголовок страницы
        $this->title .= " :: {$this->mUsers->Get()['name']}";

        // Подготовить внутренний шаблон страницы для передачи его в базовый шаблон
        $this->content = $this->GetHtml( 'v_user_panel.php',
            array(
                'user' => $this->mUsers->Get(), // данные пользователя
                'can' => $this->can, // флаг для доступа в панель администрирования сайтом
                'message' => $message, // сообщение об ошибке
            )
        );
    }
}