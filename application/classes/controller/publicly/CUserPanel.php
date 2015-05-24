<?php 

namespace Classes\Controller\Publicly;

use Classes\Controller\CBasePublicly;

/**
 * Контроллер страницы профиля, зарегестрированного пользователя
 */
class CUserPanel extends CBasePublicly
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
        $this->mUsers->clearSessions();

        // Если пользователь не зарегистрирован - отправляем на страницу регистрации.
        if (count($this->mUsers->get()) === 0) {
            $this->redirect('/auth/login');
        }

        // Если пользователь получил ban, дать отлуп
        if (false !== $this->mUsers->can('NO_ACCESS')) {
            $this->redirect('/auth/logout');
        }

        $this->can = false;

        // проверить право доступа в админку
        if (false === $this->mUsers->can('USER')) {
            $this->can = true;
        }

        $this->title = 'Профиль пользователя';
    }


    /**
     * Экшн страницы профиля
     */
    public function actionIndex()
    {
        if ($this->isPost()) {
            // Поля равны и в том случае, если пользователь их не заполнял
            if ($_POST['password'] == $_POST['confirm']) {
                // обновить данные о пользователе
                $result = $this->mUsers->change($_POST['username'], $_POST['password']);
                // Если неудача, значит на данный момент пользователь уже не авторизован
                if (false === $result) {
                    $this->redirect('/auth/login');
                }
                
            } else {
                $message = 'Поля "Пароль" и "Повторить пароль" не совпадают.';
            }

        }

        // Передать имя пользователя в заголовок страницы
        $this->title .= " :: {$this->mUsers->get()['name']}";

        // Подготовить внутренний шаблон страницы для передачи его в базовый шаблон
        $this->content = $this->getHtml(
            'v_user_panel.php',
            array(
                'user' => $this->mUsers->get(), // данные пользователя
                'can' => $this->can, // флаг для доступа в панель администрирования сайтом
                'message' => $message // сообщение об ошибке
            )
        );
    }
}
