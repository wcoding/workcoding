<?php
/**
 * Контроллер менеджера пользователей сайта
 */

class C_UsersEditor extends C_BaseAdmin
{

    protected function before()
    {

        parent::before();

        // Проверить право доступа к менеджеру пользователей
        if ( ! $this->mUsers->Can('USE_EDIT_ADD_USERS') )
        {
            header('Location: index.php?c=editor');
            exit;
        }
    }


    /**
     * Экшн главной страницы редактора пользователей.
     */
    public function action_index()
    {

        // Название страницы
        $this->title .= ' :: Редактор пользователей';

        // Подготовить внутренний шаблон страницы для передачи его в базовый шаблон
        $this->content = $this->GetHtml( 'v_users_editor.php',
            array(
                'users' => $this->mUsers->GetAll(),
            )
        );
    }



    public function action_edit()
    {
        // Нажали кнопку, хотим изменить данные
        if($this->IsPost()){

            // Если валидация полей формы прошла успешно и данные сохранены
            if( FALSE !== $this->mUsers->Edit($_POST['userID'], $_POST['username'], $_POST['role']) ){

                header("Location: index.php?c=UsersEditor&act=edit&id={$_POST['userID']}");
                exit;
            }
            else{
                $message = 'Все поля должны быть заполнены.';
                $user = $this->mUsers->Get($_GET['id']);
            }
        }
        // Только пришли
        elseif( isset($_GET['id']) and $_GET['id'] != '' ){

            // Запросить в базе, данные пользователя
            $user = $this->mUsers->Get($_GET['id']);

            // Если был передан id несуществующего пользователя
            if( 1 > count($this->mUsers->Get($_GET['id'])) ){
                $this->NotFound();
            }
        }
        // Если id пользователя не указан
        else{
            $this->NotFound();
        }

        // Название страницы
        $this->title .= ' :: Редактировать данные';

        // Подготовить внутренний шаблон страницы для передачи его в базовый шаблон
        $this->content = $this->GetHtml( 'v_users_edit.php',
            array(
                'user' => $user, // массив с данными пользователя
                'roles' => $this->mUsers->GetRoles(), // список всех ролей
                'message' => $message, // сообщение валидации полей формы
            )
        );
    }
}