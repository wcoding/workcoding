<?php
/**
 * Контроллер добавление, редактирования страниц сайта
 */

class C_PagesEditor extends C_BaseAdmin
{

    protected function before(){

        parent::before();

        // Проверить право на добавление - редактирование страниц сайта
        if ( ! $this->mUsers->Can('USE_ADD_EDIT_PAGES'))
        {
            header('Location: index.php?c=editor');
            exit;
        }
    }


    /**
     * Экшн главной страницы редактора страниц.
     */
    public function action_index(){

        // Название страницы
        $this->title .= ' :: Редактор страниц сайта';

        // Подготовить внутренний шаблон страницы для передачи его в базовый шаблон
        $this->content = $this->GetHtml( 'v_pages_editor.php' );
    }
}