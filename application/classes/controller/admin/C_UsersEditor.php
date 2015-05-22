<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Контроллер менеджера пользователей сайта
 */
class C_UsersEditor extends C_BaseAdmin
{
    protected function before()
    {
        parent::before();

        // Проверить право доступа к менеджеру пользователей
        if (! $this->mUsers->can('USE_EDIT_ADD_USERS')) {
            $this->redirect('/editor');
        }
    }


    /**
     * Экшн главной страницы редактора пользователей.
     */
    public function actionIndex()
    {
        // Название страницы
        $this->title .= ' :: Редактор пользователей';

        // Подготовить внутренний шаблон страницы для передачи его в базовый шаблон
        $this->content = $this->getHtml(
            'v_users_editor.php',
            array(
                'users' => $this->mUsers->getAll(),
            )
        );
    }


    public function actionEdit()
    {
        // Нажали кнопку, хотим изменить данные
        if ($this->isPost()) {
            $save = $this->mUsers->edit($_POST['userID'], $_POST['username'], $_POST['role']);
            
            // Если валидация полей формы прошла успешно и данные сохранены
            if (0 < $save) {
                $this->redirect('/UsersEditor/edit/' . $_POST['userID']);
            } else {
                $message = 'Все поля должны быть заполнены.';
                $user = $this->mUsers->get($this->params[0]);
            }
            
            unset($save);
            
        // Если параметр id_user передан в URL
        } elseif (isset($this->params[0]) and $this->params[0] != '' ) {
            // Запросить в базе, данные пользователя
            $user = $this->mUsers->get($this->params[0]);

            // Если был передан id несуществующего пользователя
            if (1 > count($user)) {
                $this->notFound();
            }
            
        // Если id пользователя не указан
        } else {
            $this->notFound();
        }

        // Название страницы
        $this->title .= ' :: Редактировать данные';

        // Подготовить внутренний шаблон страницы для передачи его в базовый шаблон
        $this->content = $this->getHtml(
            'v_users_edit.php',
            array(
                'user' => $user, // массив с данными пользователя
                'roles' => $this->mUsers->getRoles(), // список всех ролей
                'message' => $message // сообщение валидации полей формы
            )
        );
    }
}
