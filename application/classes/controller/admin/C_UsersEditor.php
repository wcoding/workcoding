<?php
/**
 * Контроллер менеджера пользователей сайта
 */

class C_UsersEditor extends C_BaseAdmin
{

    protected function before(){

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
    public function action_index(){

        // Название страницы
        $this->title .= ' :: Редактор пользователей';

        // Подготовить внутренний шаблон страницы для передачи его в базовый шаблон
        $this->content = $this->GetHtml( 'v_users_editor.php' );
    }
}